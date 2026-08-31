<?php

namespace App\Support\BulkImport;

use App\Models\Cargo;
use App\Models\CargosAdministrativo;
use App\Models\CatalogoCurso;
use App\Models\Discapacidade;
use App\Models\Municipio;
use App\Models\Oficiale;
use App\Models\OficialesAcademico;
use App\Models\OficialesCargo;
use App\Models\OficialesCurso;
use App\Models\OficialesFamiliare;
use App\Models\OficialesSalud;
use App\Models\OficialesVacacione;
use App\Models\Parroquia;
use App\Support\ReposoEstatusSync;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BulkImportService
{
    public function downloadTemplate(string $moduleKey): StreamedResponse
    {
        $module = BulkImportRegistry::get($moduleKey);
        if (! $module) {
            abort(404, 'Módulo no encontrado');
        }

        $spreadsheet = new Spreadsheet();

        // Hoja 1: datos
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Datos');
        $headers = array_column($module['columns'], 'label');
        $examples = array_column($module['columns'], 'example');

        foreach ($headers as $i => $header) {
            $col = Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue($col.'1', $header);
            $sheet->setCellValue($col.'2', $examples[$i] ?? '');
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastCol = Coordinate::stringFromColumnIndex(count($headers));
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A4574']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Hoja 2: guía
        $guide = $spreadsheet->createSheet();
        $guide->setTitle('Guía');
        $guide->setCellValue('A1', 'Campo');
        $guide->setCellValue('B1', 'Obligatorio');
        $guide->setCellValue('C1', 'Descripción / valores');
        $guide->setCellValue('D1', 'Ejemplo');
        $guide->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F2744']],
        ]);

        $row = 2;
        foreach ($module['columns'] as $col) {
            $guide->setCellValue('A'.$row, $col['label']);
            $guide->setCellValue('B'.$row, $col['required'] ? 'Sí' : 'No');
            $guide->setCellValue('C'.$row, $col['help'] ?? '');
            $guide->setCellValue('D'.$row, $col['example'] ?? '');
            $row++;
        }

        $row++;
        $guide->setCellValue('A'.$row, 'Notas');
        $guide->getStyle('A'.$row)->getFont()->setBold(true);
        $row++;
        foreach ($module['notes'] ?? [] as $note) {
            $guide->setCellValue('A'.$row, '• '.$note);
            $guide->mergeCells("A{$row}:D{$row}");
            $row++;
        }

        foreach (range('A', 'D') as $c) {
            $guide->getColumnDimension($c)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);
        $filename = 'plantilla_'.$moduleKey.'_'.date('Ymd').'.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function import(string $moduleKey, UploadedFile $file): array
    {
        $module = BulkImportRegistry::get($moduleKey);
        if (! $module) {
            return ['ok' => false, 'msj' => 'Módulo no válido.', 'created' => 0, 'skipped' => 0, 'errors' => []];
        }

        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false);

        if (count($rows) < 2) {
            return ['ok' => false, 'msj' => 'El archivo no tiene filas de datos.', 'created' => 0, 'skipped' => 0, 'errors' => []];
        }

        $headerRow = array_map(fn ($h) => $this->normalizeHeader((string) $h), $rows[0]);
        $expected = array_column($module['columns'], 'label');
        $map = [];
        foreach ($expected as $col) {
            $idx = array_search($this->normalizeHeader($col), $headerRow, true);
            if ($idx === false) {
                // permitir columnas opcionales ausentes
                $def = collect($module['columns'])->firstWhere('label', $col);
                if ($def && $def['required']) {
                    return [
                        'ok' => false,
                        'msj' => "Falta la columna obligatoria: {$col}",
                        'created' => 0,
                        'skipped' => 0,
                        'errors' => [],
                    ];
                }
                $map[$col] = null;
            } else {
                $map[$col] = $idx;
            }
        }

        $created = 0;
        $skipped = 0;
        $failed = 0;
        $errors = [];
        $totalRows = 0;
        $emptyRows = 0;

        DB::beginTransaction();
        try {
            for ($i = 1; $i < count($rows); $i++) {
                $raw = $rows[$i];
                if ($this->rowIsEmpty($raw)) {
                    $emptyRows++;

                    continue;
                }

                $totalRows++;

                $data = [];
                foreach ($map as $col => $idx) {
                    $data[$col] = $idx === null ? null : $this->cell($raw[$idx] ?? null);
                }

                $line = $i + 1;
                try {
                    $result = match ($moduleKey) {
                        'funcionarios' => $this->importFuncionario($data),
                        'familiares' => $this->importFamiliar($data),
                        'academia' => $this->importAcademia($data),
                        'cursos' => $this->importCurso($data),
                        'jerarquias' => $this->importJerarquia($data),
                        'reposos' => $this->importReposo($data),
                        'vacaciones' => $this->importVacacion($data),
                        default => ['status' => 'error', 'message' => 'Módulo no implementado'],
                    };

                    if (($result['status'] ?? '') === 'created') {
                        $created++;
                    } elseif (($result['status'] ?? '') === 'skipped') {
                        $skipped++;
                        if (! empty($result['message'])) {
                            $errors[] = "Fila {$line}: ".$result['message'];
                        }
                    } else {
                        $failed++;
                        $errors[] = "Fila {$line}: ".($result['message'] ?? 'Error desconocido');
                    }
                } catch (\Throwable $e) {
                    $failed++;
                    $errors[] = "Fila {$line}: ".$e->getMessage();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'ok' => false,
                'msj' => 'Error al importar: '.$e->getMessage(),
                'created' => 0,
                'skipped' => 0,
                'failed' => 0,
                'total_rows' => $totalRows,
                'empty_rows' => $emptyRows,
                'errors' => $errors,
            ];
        }

        $hasIssues = $skipped > 0 || $failed > 0;
        $summary = "Procesadas {$totalRows} filas: {$created} creados";
        if ($skipped > 0) {
            $summary .= ", {$skipped} omitidos";
        }
        if ($failed > 0) {
            $summary .= ", {$failed} con error";
        }
        if ($emptyRows > 0) {
            $summary .= " ({$emptyRows} filas vacías ignoradas)";
        }
        $summary .= '.';

        return [
            'ok' => true,
            'msj' => $summary,
            'created' => $created,
            'skipped' => $skipped,
            'failed' => $failed,
            'total_rows' => $totalRows,
            'empty_rows' => $emptyRows,
            'has_issues' => $hasIssues,
            'errors' => $errors,
        ];
    }

    private function importFuncionario(array $d): array
    {
        $doc = $this->require($d, 'documento_identidad');
        if (Oficiale::where('documento_identidad', $doc)->exists()) {
            return ['status' => 'skipped', 'message' => "Documento {$doc} ya existe"];
        }

        $tipo = Oficiale::normalizeTipo($this->require($d, 'tipo_funcionario'));
        $estatus = $this->require($d, 'estatus');
        if (! in_array($estatus, Oficiale::ESTATUS, true)) {
            throw new \InvalidArgumentException("estatus inválido: {$estatus}");
        }

        $cargoId = null;
        if (! empty($d['cargo'])) {
            $cargo = CargosAdministrativo::firstOrCreate(
                ['nombre_cargo' => trim($d['cargo'])],
                ['nombre_cargo' => trim($d['cargo'])]
            );
            $cargoId = $cargo->id;
        }

        $sabe = in_array((string) ($d['sabe_conducir'] ?? '0'), ['1', 'true', 'Si', 'SI'], true);
        $tipos = null;
        if ($sabe && ! empty($d['tipos_conduccion'])) {
            $tipos = array_values(array_filter(array_map('trim', preg_split('/[;,|]/', (string) $d['tipos_conduccion']))));
            $allowed = Oficiale::TIPOS_CONDUCCION;
            $tipos = array_values(array_intersect($tipos, $allowed));
            if ($tipos === []) {
                $tipos = null;
            }
        }

        $viviendaRaw = trim((string) ($d['tipo_vivienda'] ?? ''));
        $vivienda = $viviendaRaw !== '' ? Oficiale::normalizeTipoVivienda($viviendaRaw) : null;
        if ($viviendaRaw !== '' && $vivienda === null) {
            throw new \InvalidArgumentException("tipo_vivienda inválido: {$viviendaRaw}");
        }

        $sexo = trim((string) ($d['sexo'] ?? ''));
        if ($sexo !== '' && ! in_array($sexo, Oficiale::SEXOS, true)) {
            throw new \InvalidArgumentException("sexo inválido: {$sexo}");
        }

        Oficiale::create([
            'documento_identidad' => $doc,
            'nombre_completo' => $this->require($d, 'nombre_completo'),
            'fecha_nacimiento' => $this->date($this->require($d, 'fecha_nacimiento')),
            'sexo' => $sexo !== '' ? $sexo : null,
            'numero_placa' => filled($d['numero_placa'] ?? null) ? trim((string) $d['numero_placa']) : null,
            'fecha_ingreso' => $this->date($this->require($d, 'fecha_ingreso')),
            'estatus' => $estatus,
            'tipo_funcionario' => $tipo,
            'telefono' => filled($d['telefono'] ?? null) ? trim((string) $d['telefono']) : null,
            'correo_electronico' => filled($d['correo_electronico'] ?? null) ? trim((string) $d['correo_electronico']) : null,
            'cargo_administrativo_id' => $cargoId,
            'tipo_sangre' => $d['tipo_sangre'] ?: null,
            'estado_civil' => $d['estado_civil'] ?: null,
            'direccion' => $d['direccion'] ?: null,
            'centro_votacion' => $d['centro_votacion'] ?: null,
            'parroquia_id' => $this->resolveParroquiaId($d['municipio'] ?? null, $d['parroquia'] ?? null),
            'tipo_vivienda' => $vivienda,
            'direccion_vivienda' => ($vivienda === 'No posee' || ! $vivienda) ? null : ($d['direccion_vivienda'] ?: null),
            'sabe_conducir' => $sabe,
            'tipos_conduccion' => $tipos,
            'telefono_residencial' => $d['telefono_residencial'] ?: null,
            'talla_camisa' => $d['talla_camisa'] ?: null,
            'talla_pantalon' => $d['talla_pantalon'] ?: null,
            'talla_zapatos' => $d['talla_zapatos'] ?: null,
            'talla_saco' => $d['talla_saco'] ?: null,
            'talla_kepin_toka' => $d['talla_kepin_toka'] ?: null,
            'talla_tacon' => $d['talla_tacon'] ?: null,
            'talla_falda' => $d['talla_falda'] ?: null,
            'talla_gorra' => $d['talla_gorra'] ?: null,
        ]);

        return ['status' => 'created'];
    }

    private function importFamiliar(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $posee = in_array((string) ($d['posee_discapacidad'] ?? '0'), ['1', 'true', 'Si', 'SI'], true);
        $discId = null;
        if ($posee) {
            $nombreDisc = trim((string) ($d['discapacidad'] ?? ''));
            if ($nombreDisc === '') {
                throw new \InvalidArgumentException('discapacidad es obligatoria si posee_discapacidad=1');
            }
            $disc = Discapacidade::firstOrCreate(['nombre' => $nombreDisc], ['nombre' => $nombreDisc]);
            $discId = $disc->id;
        }

        $sexo = strtoupper(trim((string) $this->require($d, 'sexo')));
        if (! in_array($sexo, ['M', 'F'], true)) {
            throw new \InvalidArgumentException('sexo debe ser M o F');
        }

        OficialesFamiliare::create([
            'id_policia' => $oficial->id,
            'nombre_completo' => $this->require($d, 'nombre_completo'),
            'parentesco' => $this->require($d, 'parentesco'),
            'fecha_nacimiento' => $this->date($this->require($d, 'fecha_nacimiento')),
            'sexo' => $sexo,
            'telefono' => $d['telefono'] ?: null,
            'direccion' => $d['direccion'] ?: null,
            'edad' => ($d['edad'] !== null && $d['edad'] !== '') ? (int) $d['edad'] : null,
            'posee_discapacidad' => $posee,
            'discapacidad_id' => $discId,
            'discapacidad_requerimientos' => $posee ? ($d['discapacidad_requerimientos'] ?: null) : null,
            'discapacidad_observaciones' => $posee ? ($d['discapacidad_observaciones'] ?: null) : null,
        ]);

        return ['status' => 'created'];
    }

    private function importAcademia(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $anio = (int) $this->require($d, 'anio_graduacion');
        if ($anio < 1950 || $anio > 2100) {
            throw new \InvalidArgumentException('anio_graduacion fuera de rango');
        }

        OficialesAcademico::create([
            'id_policia' => $oficial->id,
            'tipo_formacion' => $this->require($d, 'tipo_formacion'),
            'titulo' => $d['titulo'] ?: null,
            'institucion' => $d['institucion'] ?: null,
            'descripcion' => $d['descripcion'] ?: null,
            'fecha_inicio' => null,
            'fecha_fin' => sprintf('%04d-12-31', $anio),
        ]);

        return ['status' => 'created'];
    }

    private function importCurso(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $nombre = trim($this->require($d, 'nombre_curso'));
        $catalogo = CatalogoCurso::firstOrCreate(['nombre' => $nombre], ['nombre' => $nombre]);
        $duracionTipo = $this->require($d, 'duracion_tipo');
        if (! in_array($duracionTipo, ['Años', 'Meses', 'Horas'], true)) {
            throw new \InvalidArgumentException('duracion_tipo inválido');
        }

        OficialesCurso::create([
            'id_policia' => $oficial->id,
            'tipo' => $this->require($d, 'tipo'),
            'nombre' => $catalogo->nombre,
            'catalogo_curso_id' => $catalogo->id,
            'institucion' => $d['institucion'] ?: null,
            'descripcion' => $d['descripcion'] ?: '',
            'fecha_inicio' => $this->date($this->require($d, 'fecha_inicio')),
            'duracion_valor' => (int) $this->require($d, 'duracion_valor'),
            'duracion_tipo' => $duracionTipo,
        ]);

        return ['status' => 'created'];
    }

    private function importJerarquia(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $nombreJerarquia = trim($this->require($d, 'jerarquia'));

        $cargo = Cargo::firstOrCreate(
            ['nombre_cargo' => $nombreJerarquia],
            ['nombre_cargo' => $nombreJerarquia]
        );

        $fechaInicio = $this->date($this->require($d, 'fecha_inicio'));
        $isActual = in_array((string) ($d['is_actual'] ?? '0'), ['1', 'true', 'Si', 'SI'], true);
        $fechaFin = null;

        if (! $isActual && filled($d['fecha_fin'] ?? null)) {
            $fechaFin = $this->date($d['fecha_fin']);
        }

        $duplicado = OficialesCargo::query()
            ->where('id_policia', $oficial->id)
            ->where('id_cargo', $cargo->id)
            ->whereDate('fecha_inicio', $fechaInicio)
            ->exists();

        if ($duplicado) {
            return [
                'status' => 'skipped',
                'message' => "Jerarquía {$nombreJerarquia} con la misma fecha de inicio ya existe para {$oficial->documento_identidad}",
            ];
        }

        if ($isActual) {
            OficialesCargo::query()
                ->where('id_policia', $oficial->id)
                ->update(['is_actual' => 0]);
        }

        OficialesCargo::create([
            'id_policia' => $oficial->id,
            'id_cargo' => $cargo->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'is_actual' => $isActual ? 1 : 0,
        ]);

        return ['status' => 'created'];
    }

    private function importReposo(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $estado = (int) $this->require($d, 'estado_reposo');
        if (! in_array($estado, [0, 1, 2], true)) {
            throw new \InvalidArgumentException('estado_reposo debe ser 0, 1 o 2');
        }

        $inicio = $this->date($this->require($d, 'fecha_reposo_inicio'));
        $fin = ! empty($d['fecha_reposo_fin']) ? $this->date($d['fecha_reposo_fin']) : null;

        if ($estado === ReposoEstatusSync::VIGENTE_SI && ! $fin) {
            throw new \InvalidArgumentException('fecha_reposo_fin obligatoria si estado_reposo=1');
        }
        if ($estado === ReposoEstatusSync::VIGENTE_CONTINUO) {
            $fin = null;
        }

        $dias = null;
        if ($inicio && $fin) {
            $dias = $this->businessDays($inicio, $fin);
        }

        if ($estado === ReposoEstatusSync::VIGENTE_SI && $fin && Carbon::parse($fin)->lte(Carbon::today())) {
            $estado = ReposoEstatusSync::VIGENTE_NO;
        }

        OficialesSalud::create([
            'id_policia' => $oficial->id,
            'fecha_revision' => $this->date($this->require($d, 'fecha_revision')),
            'diagnostico' => $this->require($d, 'diagnostico'),
            'fecha_reposo_inicio' => $inicio,
            'fecha_reposo_fin' => $fin,
            'dias_reposo' => $dias,
            'is_vigente' => $estado,
        ]);

        ReposoEstatusSync::actualizarEstatusFuncionario((int) $oficial->id);

        return ['status' => 'created'];
    }

    private function importVacacion(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $estatus = strtoupper(trim($this->require($d, 'estatus')));
        $reintegro = ! empty($d['fecha_reintegro']) ? $this->date($d['fecha_reintegro']) : null;
        $disfrutadas = in_array((string) ($d['is_disfrutadas'] ?? '0'), ['1', 'true', 'Si', 'SI'], true) ? 1 : 0;
        if ($reintegro && Carbon::parse($reintegro)->lte(Carbon::today())) {
            $disfrutadas = 1;
        }

        OficialesVacacione::create([
            'id_policia' => $oficial->id,
            'fecha_emision' => $this->date($this->require($d, 'fecha_emision')),
            'fecha_reintegro' => $reintegro,
            'estatus' => $estatus,
            'descripcion' => $d['descripcion'] ?: null,
            'is_disfrutadas' => $disfrutadas,
        ]);

        return ['status' => 'created'];
    }

    private function resolveParroquiaId(?string $municipio, ?string $parroquia): ?int
    {
        $municipio = trim((string) $municipio);
        $parroquia = trim((string) $parroquia);

        if ($municipio === '' || $parroquia === '') {
            return null;
        }

        $mun = Municipio::query()
            ->where('estado_id', Municipio::ESTADO_TRUJILLO_ID)
            ->where('descripcion', $municipio)
            ->first();

        if (! $mun) {
            $mun = Municipio::create([
                'descripcion' => $municipio,
                'estado_id' => Municipio::ESTADO_TRUJILLO_ID,
            ]);
        }

        $par = Parroquia::query()
            ->where('municipio_id', $mun->id)
            ->where('descripcion', $parroquia)
            ->first();

        if (! $par) {
            $par = Parroquia::create([
                'descripcion' => $parroquia,
                'municipio_id' => $mun->id,
                'atencionfamilias' => 0,
            ]);
        }

        return (int) $par->id;
    }

    private function findOficial(string $documento): Oficiale
    {
        $oficial = Oficiale::where('documento_identidad', $documento)->first();
        if (! $oficial) {
            throw new \InvalidArgumentException("Funcionario con documento {$documento} no encontrado");
        }

        return $oficial;
    }

    private function require(array $d, string $key): string
    {
        $value = trim((string) ($d[$key] ?? ''));
        if ($value === '') {
            throw new \InvalidArgumentException("Campo obligatorio vacío: {$key}");
        }

        return $value;
    }

    private function date(string|int|float $value): string
    {
        // Excel a veces entrega el número de serie de fecha
        if (is_numeric($value) && ! preg_match('/^\d{4}-\d{2}-\d{2}/', (string) $value)) {
            try {
                $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $value);

                return $dt->format('Y-m-d');
            } catch (\Throwable) {
                // continuar con otros formatos
            }
        }

        $str = trim((string) $value);
        if ($str === '') {
            throw new \InvalidArgumentException('Fecha vacía');
        }

        // dd/mm/yyyy, d/m/yy, o año con dígito extra (ej. 03/08/20012 → 2012)
        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d+)$/', $str, $m)) {
            $day = (int) $m[1];
            $month = (int) $m[2];
            $year = $this->normalizeDateYear($m[3]);

            if (! checkdate($month, $day, $year)) {
                throw new \InvalidArgumentException("Fecha inválida: {$str}");
            }

            return sprintf('%04d-%02d-%02d', $year, $month, $day);
        }

        if (preg_match('/^(\d{4,})-(\d{1,2})-(\d{1,2})$/', $str, $m)) {
            $year = $this->normalizeDateYear($m[1]);
            $month = (int) $m[2];
            $day = (int) $m[3];

            if (! checkdate($month, $day, $year)) {
                throw new \InvalidArgumentException("Fecha inválida: {$str}");
            }

            return sprintf('%04d-%02d-%02d', $year, $month, $day);
        }

        try {
            return Carbon::parse($str)->toDateString();
        } catch (\Throwable) {
            throw new \InvalidArgumentException("Fecha inválida: {$str}");
        }
    }

    private function normalizeDateYear(string $rawYear): int
    {
        $year = preg_replace('/\D/', '', $rawYear) ?? '';
        if ($year === '') {
            throw new \InvalidArgumentException('Año de fecha inválido');
        }

        if (strlen($year) === 4) {
            return (int) $year;
        }

        if (strlen($year) === 2) {
            $y = (int) $year;

            return $y >= 50 ? 1900 + $y : 2000 + $y;
        }

        // Año con dígitos de más (ej. 20012 → 2012): quitar un carácter hasta obtener año válido
        if (strlen($year) >= 5 && strlen($year) <= 7) {
            for ($i = 0; $i < strlen($year); $i++) {
                $candidate = substr($year, 0, $i).substr($year, $i + 1);
                if (strlen($candidate) === 4) {
                    $y = (int) $candidate;
                    if ($y >= 1900 && $y <= 2100) {
                        return $y;
                    }
                }
            }

            $first = (int) substr($year, 0, 4);
            if ($first >= 1900 && $first <= 2100) {
                return $first;
            }

            $last = (int) substr($year, -4);
            if ($last >= 1900 && $last <= 2100) {
                return $last;
            }
        }

        throw new \InvalidArgumentException("Año de fecha inválido: {$rawYear}");
    }

    private function businessDays(string $inicio, string $fin): int
    {
        $start = Carbon::parse($inicio)->startOfDay();
        $end = Carbon::parse($fin)->startOfDay();
        $days = 0;
        while ($start->lte($end)) {
            if ($start->isWeekday()) {
                $days++;
            }
            $start->addDay();
        }

        return $days;
    }

    private function normalizeHeader(string $h): string
    {
        return strtolower(trim(preg_replace('/\s+/', '_', $h) ?? $h));
    }

    private function cell(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }
        if (is_float($value) || is_int($value)) {
            // evitar notación científica en cédulas
            if (floor((float) $value) == $value) {
                return (string) (int) $value;
            }

            return (string) $value;
        }

        $str = trim((string) $value);

        return $str === '' ? null : $str;
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $v) {
            if ($v !== null && trim((string) $v) !== '') {
                return false;
            }
        }

        return true;
    }
}
