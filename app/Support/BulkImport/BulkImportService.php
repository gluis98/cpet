<?php

namespace App\Support\BulkImport;

use App\Models\Cargo;
use App\Models\CargosAdministrativo;
use App\Models\CatalogoCurso;
use App\Models\CentroVotacion;
use App\Models\Discapacidade;
use App\Models\Estacione;
use App\Models\Municipio;
use App\Models\Oficiale;
use App\Models\OficialesAcademico;
use App\Models\OficialesCargo;
use App\Models\OficialesCurso;
use App\Models\OficialesFamiliare;
use App\Models\OficialesRadiograma;
use App\Models\OficialesReconocimiento;
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
    /** @var array<string, true> */
    private array $importSeenKeys = [];

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
        $resolved = $this->resolveImportRows($spreadsheet, $module);

        if ($resolved === null) {
            $sheet = $spreadsheet->getSheetByName('Datos') ?? $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, false);

            if (count($rows) < 2) {
                return ['ok' => false, 'msj' => 'El archivo no tiene filas de datos.', 'created' => 0, 'skipped' => 0, 'errors' => []];
            }

            $resolved = [
                'rows' => $rows,
                'headerRowIndex' => $this->detectHeaderRowIndex($rows, $module),
                'sheetName' => $sheet->getTitle(),
            ];
        }

        $rows = $resolved['rows'];
        $headerRowIndex = $resolved['headerRowIndex'];
        $headerRow = array_map(fn ($h) => $this->normalizeHeader((string) $h), $rows[$headerRowIndex]);
        $map = [];
        $maxColumnIndex = 0;
        $usedIndices = [];

        foreach ($module['columns'] as $columnDef) {
            $key = $columnDef['key'];
            $indices = $this->resolveColumnIndices($columnDef, $headerRow, $usedIndices, $rows, $headerRowIndex);

            if ($indices === []) {
                if (($columnDef['key'] ?? '') === 'documento_identidad') {
                    $indices = $this->resolveDocumentoFuzzyIndices($headerRow, $usedIndices, $rows, $headerRowIndex);
                }

                if ($indices === [] && ($columnDef['required'] ?? false)) {
                    return [
                        'ok' => false,
                        'msj' => $this->missingRequiredColumnMessage($columnDef['label'], $rows, $headerRowIndex),
                        'created' => 0,
                        'skipped' => 0,
                        'errors' => [],
                    ];
                }

                if ($indices === []) {
                    $map[$key] = null;

                    continue;
                }
            }
            if ($indices !== []) {
                $map[$key] = $indices;
                foreach ($indices as $idx) {
                    $usedIndices[] = $idx;
                    $maxColumnIndex = max($maxColumnIndex, $idx);
                }
            }
        }

        $created = 0;
        $skipped = 0;
        $failed = 0;
        $dedupedTotal = 0;
        $errors = [];
        $totalRows = 0;
        $emptyRows = 0;

        $this->resetImportSession();

        DB::beginTransaction();
        try {
            for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
                $raw = $this->padRow($rows[$i], $maxColumnIndex + 1);
                if ($this->rowIsEmpty($raw)) {
                    $emptyRows++;

                    continue;
                }

                $totalRows++;

                $data = [];
                foreach ($map as $key => $indices) {
                    $data[$key] = $indices === null ? null : $this->readCell($raw, $indices);
                }

                $line = $i + 1;
                try {
                    $result = match ($moduleKey) {
                        'funcionarios' => $this->importFuncionario($data),
                        'cargos_funcionarios' => $this->importCargoFuncionario($data),
                        'familiares' => $this->importFamiliar($data),
                        'academia' => $this->importAcademia($data),
                        'cursos' => $this->importCurso($data),
                        'jerarquias' => $this->importJerarquia($data),
                        'reposos' => $this->importReposo($data),
                        'vacaciones' => $this->importVacacion($data),
                        'reconocimientos' => $this->importReconocimiento($data),
                        'radiogramas' => $this->importRadiograma($data),
                        default => ['status' => 'error', 'message' => 'Módulo no implementado'],
                    };

                    $dedupedTotal += (int) ($result['deduped'] ?? 0);

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
        if ($dedupedTotal > 0) {
            $summary .= ", {$dedupedTotal} duplicado(s) eliminado(s) en BD";
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
            'deduped' => $dedupedTotal,
            'total_rows' => $totalRows,
            'empty_rows' => $emptyRows,
            'has_issues' => $hasIssues,
            'errors' => $errors,
        ];
    }

    private function importFuncionario(array $d): array
    {
        $doc = $this->normalizeDocumento($this->require($d, 'documento_identidad'));
        $matchFn = fn ($q) => $q->where('documento_identidad', $doc);

        return $this->importUnique('funcionarios', $doc, Oficiale::class, $matchFn, function () use ($d, $doc) {
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

            $parroquiaId = $this->resolveParroquiaId($d['municipio'] ?? null, $d['parroquia'] ?? null);
            $centroNombre = trim((string) ($d['centro_votacion'] ?? ''));
            $centroVotacionId = null;
            if ($centroNombre !== '') {
                $centroVotacionId = $this->resolveCentroVotacionId(
                    $d['municipio'] ?? null,
                    $d['parroquia'] ?? null,
                    $centroNombre
                );
                $centro = CentroVotacion::find($centroVotacionId);
                if ($centro) {
                    $centroNombre = $centro->nombre;
                    $parroquiaId = $parroquiaId ?? $centro->parroquia_id;
                }
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
                'centro_votacion' => $centroNombre !== '' ? $centroNombre : null,
                'centro_votacion_id' => $centroVotacionId,
                'parroquia_id' => $parroquiaId,
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
        });
    }

    private function importCargoFuncionario(array $d): array
    {
        $doc = $this->normalizeDocumento($this->require($d, 'documento_identidad'));
        $cargoNombre = trim($this->require($d, 'cargo'));
        $rowKey = $doc.'|'.$this->normalizeMatchText($cargoNombre);

        $deduped = $this->dedupeRecords(Oficiale::class, fn ($q) => $q->where('documento_identidad', $doc));

        if ($this->isImportRowSeen('cargos_funcionarios', $rowKey)) {
            return [
                'status' => 'skipped',
                'message' => $this->skipMessage('Fila duplicada en el archivo', $deduped),
                'deduped' => $deduped,
            ];
        }
        $this->markImportRowSeen('cargos_funcionarios', $rowKey);

        $oficial = $this->findOficial($doc);
        $cargo = CargosAdministrativo::firstOrCreate(
            ['nombre_cargo' => $cargoNombre],
            ['nombre_cargo' => $cargoNombre]
        );

        if ((int) $oficial->cargo_administrativo_id === (int) $cargo->id) {
            return [
                'status' => 'skipped',
                'message' => $this->skipMessage("Cargo {$cargoNombre} ya asignado a {$doc}", $deduped),
                'deduped' => $deduped,
            ];
        }

        $oficial->update(['cargo_administrativo_id' => $cargo->id]);

        return ['status' => 'created', 'deduped' => $deduped];
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

        $nombre = trim($this->requireAny($d, ['nombre_completo', 'nombre_familiar'], 'nombre_completo'));
        $parentesco = trim($this->require($d, 'parentesco'));
        $fechaNacimiento = $this->date($this->require($d, 'fecha_nacimiento'));
        $rowKey = "{$oficial->id}|{$this->normalizeMatchText($nombre)}|{$this->normalizeMatchText($parentesco)}|{$fechaNacimiento}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->whereRaw('LOWER(TRIM(nombre_completo)) = ?', [$this->normalizeMatchText($nombre)])
            ->whereRaw('LOWER(TRIM(parentesco)) = ?', [$this->normalizeMatchText($parentesco)])
            ->whereDate('fecha_nacimiento', $fechaNacimiento);

        return $this->importUnique('familiares', $rowKey, OficialesFamiliare::class, $matchFn, function () use ($oficial, $d, $nombre, $parentesco, $fechaNacimiento, $sexo, $posee, $discId) {
            OficialesFamiliare::create([
                'id_policia' => $oficial->id,
                'nombre_completo' => $nombre,
                'parentesco' => $parentesco,
                'fecha_nacimiento' => $fechaNacimiento,
                'sexo' => $sexo,
                'telefono' => $d['telefono'] ?: null,
                'direccion' => $d['direccion'] ?: null,
                'edad' => ($d['edad'] !== null && $d['edad'] !== '') ? (int) $d['edad'] : null,
                'posee_discapacidad' => $posee,
                'discapacidad_id' => $discId,
                'discapacidad_requerimientos' => $posee ? ($d['discapacidad_requerimientos'] ?: null) : null,
                'discapacidad_observaciones' => $posee ? ($d['discapacidad_observaciones'] ?: null) : null,
            ]);
        });
    }

    private function importAcademia(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $anio = (int) $this->require($d, 'anio_graduacion');
        if ($anio < 1950 || $anio > 2100) {
            throw new \InvalidArgumentException('anio_graduacion fuera de rango');
        }

        $tipoFormacion = trim($this->require($d, 'tipo_formacion'));
        $fechaFin = sprintf('%04d-12-31', $anio);
        $titulo = trim((string) ($d['titulo'] ?? ''));
        $rowKey = "{$oficial->id}|{$this->normalizeMatchText($tipoFormacion)}|{$fechaFin}|{$this->normalizeMatchText($titulo)}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->where('tipo_formacion', $tipoFormacion)
            ->whereDate('fecha_fin', $fechaFin)
            ->when(
                $titulo !== '',
                fn ($query) => $query->whereRaw('LOWER(TRIM(COALESCE(titulo, ""))) = ?', [$this->normalizeMatchText($titulo)]),
                fn ($query) => $query->where(function ($inner) {
                    $inner->whereNull('titulo')->orWhereRaw('TRIM(titulo) = ?', ['']);
                })
            );

        return $this->importUnique('academia', $rowKey, OficialesAcademico::class, $matchFn, function () use ($oficial, $d, $tipoFormacion, $fechaFin) {
            OficialesAcademico::create([
                'id_policia' => $oficial->id,
                'tipo_formacion' => $tipoFormacion,
                'titulo' => $d['titulo'] ?: null,
                'institucion' => $d['institucion'] ?: null,
                'descripcion' => $d['descripcion'] ?: null,
                'fecha_inicio' => null,
                'fecha_fin' => $fechaFin,
            ]);
        });
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

        $tipo = trim($this->require($d, 'tipo'));
        $fechaInicio = $this->date($this->require($d, 'fecha_inicio'));
        $rowKey = "{$oficial->id}|{$catalogo->id}|{$this->normalizeMatchText($tipo)}|{$fechaInicio}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->where('tipo', $tipo)
            ->whereDate('fecha_inicio', $fechaInicio)
            ->where(function ($inner) use ($catalogo) {
                $inner->where('catalogo_curso_id', $catalogo->id)
                    ->orWhereRaw('LOWER(TRIM(COALESCE(nombre, ""))) = ?', [$this->normalizeMatchText($catalogo->nombre)]);
            });

        return $this->importUnique('cursos', $rowKey, OficialesCurso::class, $matchFn, function () use ($oficial, $d, $catalogo, $tipo, $fechaInicio, $duracionTipo) {
            OficialesCurso::create([
                'id_policia' => $oficial->id,
                'tipo' => $tipo,
                'nombre' => $catalogo->nombre,
                'catalogo_curso_id' => $catalogo->id,
                'institucion' => $d['institucion'] ?: null,
                'descripcion' => $d['descripcion'] ?: '',
                'fecha_inicio' => $fechaInicio,
                'duracion_valor' => (int) $this->require($d, 'duracion_valor'),
                'duracion_tipo' => $duracionTipo,
            ]);
        });
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

        $rowKey = "{$oficial->id}|{$cargo->id}|{$fechaInicio}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->where('id_cargo', $cargo->id)
            ->whereDate('fecha_inicio', $fechaInicio);

        return $this->importUnique('jerarquias', $rowKey, OficialesCargo::class, $matchFn, function () use ($oficial, $cargo, $fechaInicio, $fechaFin, $isActual, $nombreJerarquia) {
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
        }, "Jerarquía {$nombreJerarquia} con la misma fecha de inicio ya existe");
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
        $fechaRevision = $this->date($this->require($d, 'fecha_revision'));
        $diagnostico = trim($this->require($d, 'diagnostico'));

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

        $rowKey = "{$oficial->id}|{$inicio}|{$this->normalizeMatchText($diagnostico)}|{$fechaRevision}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->whereDate('fecha_reposo_inicio', $inicio)
            ->whereRaw('LOWER(TRIM(diagnostico)) = ?', [$this->normalizeMatchText($diagnostico)])
            ->whereDate('fecha_revision', $fechaRevision);

        $result = $this->importUnique('reposos', $rowKey, OficialesSalud::class, $matchFn, function () use ($oficial, $fechaRevision, $diagnostico, $inicio, $fin, $dias, $estado) {
            OficialesSalud::create([
                'id_policia' => $oficial->id,
                'fecha_revision' => $fechaRevision,
                'diagnostico' => $diagnostico,
                'fecha_reposo_inicio' => $inicio,
                'fecha_reposo_fin' => $fin,
                'dias_reposo' => $dias,
                'is_vigente' => $estado,
            ]);
        });

        ReposoEstatusSync::actualizarEstatusFuncionario((int) $oficial->id);

        return $result;
    }

    private function importVacacion(array $d): array
    {
        $oficial = $this->findOficial($this->requireAny($d, ['documento_identidad', 'cedula', 'documento'], 'documento_identidad'));
        $estatus = strtoupper(trim($this->requireAny($d, ['estatus', 'estado', 'status'], 'estatus')));
        $fechaEmision = $this->date($this->requireAny($d, ['fecha_emision', 'fecha_inicio', 'fecha_desde'], 'fecha_emision'));
        $hastaRaw = $this->optionalValue($d, ['fecha_hasta', 'fecha_fin', 'hasta']);
        $hasta = $hastaRaw !== null ? $this->date($hastaRaw) : null;
        $reintegroRaw = $this->optionalValue($d, ['fecha_reintegro', 'reintegro']);
        $reintegro = $reintegroRaw !== null ? $this->date($reintegroRaw) : null;
        $disfrutadasRaw = $this->optionalValue($d, ['is_disfrutadas', 'disfrutadas', 'vacaciones_disfrutadas']);
        $disfrutadas = in_array((string) ($disfrutadasRaw ?? '0'), ['1', 'true', 'Si', 'SI'], true) ? 1 : 0;
        if ($reintegro && Carbon::parse($reintegro)->lte(Carbon::today())) {
            $disfrutadas = 1;
        }

        $rowKey = "{$oficial->id}|{$fechaEmision}|{$this->normalizeMatchText($estatus)}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->whereDate('fecha_emision', $fechaEmision)
            ->whereRaw('UPPER(TRIM(estatus)) = ?', [$estatus]);

        return $this->importUnique('vacaciones', $rowKey, OficialesVacacione::class, $matchFn, function () use ($oficial, $fechaEmision, $hasta, $reintegro, $estatus, $d, $disfrutadas) {
            OficialesVacacione::create([
                'id_policia' => $oficial->id,
                'fecha_emision' => $fechaEmision,
                'fecha_hasta' => $hasta,
                'fecha_reintegro' => $reintegro,
                'estatus' => $estatus,
                'descripcion' => $this->optionalValue($d, ['descripcion', 'observaciones', 'nota']) ?: null,
                'is_disfrutadas' => $disfrutadas,
            ]);
        });
    }

    private function importReconocimiento(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $tipo = trim($this->require($d, 'tipo'));
        $tipoNorm = $this->normalizeMatchText($this->foldAccents($tipo));
        $tipoCanon = match (true) {
            str_contains($tipoNorm, 'condecor') => 'Condecoración',
            str_contains($tipoNorm, 'felicit') => 'Felicitaciones',
            str_contains($tipoNorm, 'reconoc') => 'Reconocimiento',
            default => null,
        };
        if ($tipoCanon === null) {
            throw new \InvalidArgumentException('tipo debe ser Reconocimiento, Condecoración o Felicitaciones');
        }

        $autoridad = trim($this->require($d, 'autoridad'));
        $fecha = $this->date($this->require($d, 'fecha'));
        $descripcion = trim($this->require($d, 'descripcion'));

        $rowKey = "{$oficial->id}|{$this->normalizeMatchText($this->foldAccents($tipoCanon))}|{$fecha}|{$this->normalizeMatchText($this->foldAccents($descripcion))}|{$this->normalizeMatchText($this->foldAccents($autoridad))}";
        $matchFn = function ($q) use ($oficial, $tipoCanon, $fecha, $descripcion, $autoridad) {
            $q->where('id_policia', $oficial->id)->whereDate('fecha', $fecha);

            $candidates = (clone $q)->get(['id', 'tipo', 'descripcion', 'autoridad']);
            $keepIds = $candidates->filter(function ($row) use ($tipoCanon, $descripcion, $autoridad) {
                return $this->normalizeMatchText($this->foldAccents((string) $row->tipo)) === $this->normalizeMatchText($this->foldAccents($tipoCanon))
                    && $this->normalizeMatchText($this->foldAccents((string) $row->descripcion)) === $this->normalizeMatchText($this->foldAccents($descripcion))
                    && $this->normalizeMatchText($this->foldAccents((string) ($row->autoridad ?? ''))) === $this->normalizeMatchText($this->foldAccents($autoridad));
            })->pluck('id')->all();

            if ($keepIds === []) {
                $q->whereRaw('1 = 0');
            } else {
                $q->whereIn('id', $keepIds);
            }
        };

        return $this->importUnique('reconocimientos', $rowKey, OficialesReconocimiento::class, $matchFn, function () use ($oficial, $tipoCanon, $autoridad, $fecha, $descripcion) {
            OficialesReconocimiento::create([
                'id_policia' => $oficial->id,
                'tipo' => $tipoCanon,
                'autoridad' => $autoridad,
                'fecha' => $fecha,
                'descripcion' => $descripcion,
            ]);
        });
    }

    private function importRadiograma(array $d): array
    {
        $oficial = $this->findOficial($this->require($d, 'documento_identidad'));
        $nombreEstacion = trim($this->require($d, 'estacion'));
        $nombreNorm = $this->normalizeMatchText($this->foldAccents($nombreEstacion));
        $estacion = Estacione::query()
            ->get(['id', 'estacion'])
            ->first(function ($item) use ($nombreNorm) {
                return $this->normalizeMatchText($this->foldAccents((string) $item->estacion)) === $nombreNorm;
            });

        if (! $estacion) {
            $estacion = Estacione::create([
                'estacion' => $nombreEstacion,
                'descripcion' => null,
            ]);
        }

        $fechaInicio = $this->date($this->require($d, 'fecha_inicio'));
        $fechaFinal = filled($d['fecha_final'] ?? null) ? $this->date($d['fecha_final']) : null;
        $isActual = in_array((string) ($d['is_actual'] ?? '0'), ['1', 'true', 'Si', 'SI'], true);
        $descripcion = trim((string) ($d['descripcion'] ?? ''));

        $rowKey = "{$oficial->id}|{$estacion->id}|{$fechaInicio}";
        $matchFn = fn ($q) => $q->where('id_policia', $oficial->id)
            ->where('id_estacion', $estacion->id)
            ->whereDate('fecha_inicio', $fechaInicio);

        return $this->importUnique('radiogramas', $rowKey, OficialesRadiograma::class, $matchFn, function () use ($oficial, $estacion, $fechaInicio, $fechaFinal, $isActual, $descripcion) {
            if ($isActual) {
                OficialesRadiograma::query()
                    ->where('id_policia', $oficial->id)
                    ->update(['is_actual' => 0]);
            }

            OficialesRadiograma::create([
                'id_policia' => $oficial->id,
                'id_estacion' => $estacion->id,
                'fecha_inicio' => $fechaInicio,
                'fecha_final' => $fechaFinal,
                'is_actual' => $isActual ? 1 : 0,
                'descripcion' => $descripcion !== '' ? $descripcion : null,
            ]);
        }, "Radiograma en estación {$estacion->estacion} con la misma fecha de inicio ya existe");
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

    private function resolveCentroVotacionId(?string $municipio, ?string $parroquia, string $nombre): int
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new \InvalidArgumentException('centro_votacion vacío');
        }

        $parroquiaId = $this->resolveParroquiaId($municipio, $parroquia);
        if (! $parroquiaId) {
            throw new \InvalidArgumentException('municipio y parroquia son obligatorios para registrar centro_votacion');
        }

        $par = Parroquia::findOrFail($parroquiaId);
        $centro = CentroVotacion::firstOrCreate(
            ['nombre' => $nombre, 'parroquia_id' => $parroquiaId],
            [
                'nombre' => $nombre,
                'parroquia_id' => $parroquiaId,
                'municipio_id' => $par->municipio_id,
            ]
        );

        return (int) $centro->id;
    }

    private function resetImportSession(): void
    {
        $this->importSeenKeys = [];
    }

    private function isImportRowSeen(string $module, string $key): bool
    {
        return isset($this->importSeenKeys[$module.'|'.$key]);
    }

    private function markImportRowSeen(string $module, string $key): void
    {
        $this->importSeenKeys[$module.'|'.$key] = true;
    }

    private function normalizeMatchText(string $value): string
    {
        return mb_strtolower(trim($value));
    }

    private function skipMessage(string $base, int $deduped): string
    {
        if ($deduped > 0) {
            return "{$base} ({$deduped} duplicado(s) eliminado(s) en BD)";
        }

        return $base;
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     * @param  callable(\Illuminate\Database\Eloquent\Builder): void  $matchFn
     * @param  callable(): void  $create
     */
    private function importUnique(
        string $module,
        string $rowKey,
        string $modelClass,
        callable $matchFn,
        callable $create,
        ?string $existsMessage = null
    ): array {
        $deduped = $this->dedupeRecords($modelClass, $matchFn);

        if ($this->isImportRowSeen($module, $rowKey)) {
            return [
                'status' => 'skipped',
                'message' => $this->skipMessage('Registro duplicado en el archivo', $deduped),
                'deduped' => $deduped,
            ];
        }
        $this->markImportRowSeen($module, $rowKey);

        if ($this->recordExists($modelClass, $matchFn)) {
            return [
                'status' => 'skipped',
                'message' => $this->skipMessage($existsMessage ?? 'Registro ya existente', $deduped),
                'deduped' => $deduped,
            ];
        }

        $create();
        $deduped += $this->dedupeRecords($modelClass, $matchFn);

        return ['status' => 'created', 'deduped' => $deduped];
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     * @param  callable(\Illuminate\Database\Eloquent\Builder): void  $matchFn
     */
    private function dedupeRecords(string $modelClass, callable $matchFn): int
    {
        $query = $modelClass::query();
        $matchFn($query);
        $ids = (clone $query)->orderBy('id')->pluck('id');

        if ($ids->count() <= 1) {
            return 0;
        }

        $deleteIds = $ids->slice(1)->values()->all();
        $modelClass::query()->whereIn('id', $deleteIds)->delete();

        return count($deleteIds);
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     * @param  callable(\Illuminate\Database\Eloquent\Builder): void  $matchFn
     */
    private function recordExists(string $modelClass, callable $matchFn): bool
    {
        $query = $modelClass::query();
        $matchFn($query);

        return $query->exists();
    }

    private function findOficial(string $documento): Oficiale
    {
        $documento = $this->normalizeDocumento($documento);
        $this->dedupeRecords(Oficiale::class, fn ($q) => $q->where('documento_identidad', $documento));
        $oficial = Oficiale::where('documento_identidad', $documento)->first();
        if (! $oficial) {
            throw new \InvalidArgumentException("Funcionario con documento {$documento} no encontrado");
        }

        return $oficial;
    }

    private function require(array $d, string $key): string
    {
        $raw = (string) ($d[$key] ?? '');
        $value = $this->isDocumentoKey($key)
            ? $this->normalizeDocumento($raw)
            : trim($raw);

        if ($value === '') {
            if (! array_key_exists($key, $d)) {
                throw new \InvalidArgumentException("Campo obligatorio no mapeado: {$key}");
            }

            throw new \InvalidArgumentException("Campo obligatorio vacío: {$key}");
        }

        return $value;
    }

    /**
     * @param  array<int, string>  $keys
     */
    private function requireAny(array $d, array $keys, string $label): string
    {
        foreach ($keys as $key) {
            $raw = (string) ($d[$key] ?? '');
            $value = $this->isDocumentoKey($key)
                ? $this->normalizeDocumento($raw)
                : trim($raw);
            if ($value !== '') {
                return $value;
            }
        }

        throw new \InvalidArgumentException("Campo obligatorio vacío: {$label}");
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

    /**
     * @param  array<int, string>  $keys
     */
    private function optionalValue(array $d, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = trim((string) ($d[$key] ?? ''));
            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    /**
     * @return array<int, int>
     */
    private function resolveColumnIndices(array $columnDef, array $headerRow, array $usedIndices, array $rows, int $headerRowIndex): array
    {
        $normalizedCandidates = [];
        foreach ($this->columnCandidates($columnDef) as $candidate) {
            $normalized = $this->normalizeHeader($candidate);
            if ($normalized !== '') {
                $normalizedCandidates[$normalized] = true;
            }
        }

        $matches = [];
        foreach ($headerRow as $idx => $header) {
            if ($header !== '' && isset($normalizedCandidates[$header]) && ! in_array($idx, $usedIndices, true)) {
                $matches[] = $idx;
            }
        }

        if ($matches === []) {
            return [];
        }

        if ($rows === []) {
            return $matches;
        }

        return $this->rankColumnsByFillRate($matches, $rows, $headerRowIndex);
    }

    /**
     * @return array<int, int>
     */
    private function resolveDocumentoFuzzyIndices(array $headerRow, array $usedIndices, array $rows, int $headerRowIndex): array
    {
        $matches = [];

        foreach ($headerRow as $idx => $header) {
            if ($header === '' || in_array($idx, $usedIndices, true)) {
                continue;
            }

            if ($this->headerLooksLikeDocumento($header)) {
                $matches[] = $idx;
            }
        }

        if ($matches === []) {
            return [];
        }

        return $this->rankColumnsByFillRate($matches, $rows, $headerRowIndex);
    }

    private function headerLooksLikeDocumento(string $header): bool
    {
        if (in_array($header, ['ci', 'doc'], true)) {
            return true;
        }

        if (preg_match('/_(nombre|parentesco|fecha|sexo|telefono|direccion|edad|correo|estatus)/', $header)) {
            return false;
        }

        return (bool) preg_match('/(cedula|documento|identidad|identificacion)/', $header);
    }

    /**
     * @return array<int, string>
     */
    private function columnCandidates(array $columnDef): array
    {
        return array_values(array_filter([
            $columnDef['key'] ?? null,
            $columnDef['label'] ?? null,
            ...($columnDef['aliases'] ?? []),
        ], fn ($value) => trim((string) $value) !== ''));
    }

    /**
     * @param  array<int, int>  $indices
     * @return array<int, int>
     */
    private function rankColumnsByFillRate(array $indices, array $rows, int $headerRowIndex): array
    {
        $sampleLimit = min(count($rows), $headerRowIndex + 21);
        $scores = [];

        foreach ($indices as $idx) {
            $filled = 0;
            for ($i = $headerRowIndex + 1; $i < $sampleLimit; $i++) {
                $raw = $this->padRow($rows[$i], $idx + 1);
                if ($this->cell($raw[$idx] ?? null) !== null) {
                    $filled++;
                }
            }
            $scores[$idx] = $filled;
        }

        usort($indices, fn ($a, $b) => ($scores[$b] ?? 0) <=> ($scores[$a] ?? 0));

        return $indices;
    }

    /**
     * @param  array<int, int>|null  $indices
     */
    private function readCell(array $raw, ?array $indices): ?string
    {
        if ($indices === null || $indices === []) {
            return null;
        }

        foreach ($indices as $idx) {
            $value = $this->cell($raw[$idx] ?? null);
            if ($value !== null) {
                return $value;
            }
        }

        return null;
    }

    private function normalizeDocumento(string $documento): string
    {
        $documento = trim($documento);
        if (preg_match('/^[\d.]+e[\d+]+$/i', $documento)) {
            $documento = sprintf('%.0f', (float) $documento);
        }

        $digits = preg_replace('/\D+/', '', $documento) ?? '';

        return $digits !== '' ? $digits : $documento;
    }

    private function isDocumentoKey(string $key): bool
    {
        return in_array($key, ['documento_identidad', 'cedula', 'documento', 'ci'], true);
    }

    private function resolveImportRows(Spreadsheet $spreadsheet, array $module): ?array
    {
        $best = null;
        $bestScore = -1;
        $preferredSheets = ['Datos', 'datos', 'Hoja1', 'Sheet1'];
        $sheetNames = $spreadsheet->getSheetNames();

        usort($sheetNames, function (string $a, string $b) use ($preferredSheets): int {
            $pa = array_search($a, $preferredSheets, true);
            $pb = array_search($b, $preferredSheets, true);
            $pa = $pa === false ? 99 : $pa;
            $pb = $pb === false ? 99 : $pb;

            return $pa <=> $pb;
        });

        foreach ($sheetNames as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if (! $sheet) {
                continue;
            }

            $rows = $sheet->toArray(null, true, true, false);
            if (count($rows) < 2) {
                continue;
            }

            $limit = min(count($rows), 15);
            for ($i = 0; $i < $limit; $i++) {
                if ($this->rowIsEmpty($rows[$i]) || $this->rowLooksLikeData($rows[$i])) {
                    continue;
                }

                $headerRow = array_map(fn ($h) => $this->normalizeHeader((string) $h), $rows[$i]);
                if (! $this->headerRowHasRequiredColumns($module, $headerRow, $rows, $i)) {
                    continue;
                }

                $score = $this->scoreHeaderRow($module, $headerRow, $rows, $i) - ($i * 0.01);
                if (in_array($sheetName, $preferredSheets, true)) {
                    $score += 5;
                }

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $best = [
                        'rows' => $rows,
                        'headerRowIndex' => $i,
                        'sheetName' => $sheetName,
                    ];
                }
            }
        }

        return $best;
    }

    private function detectHeaderRowIndex(array $rows, array $module): int
    {
        $limit = min(count($rows), 15);
        $bestIndex = null;
        $bestScore = -1;

        for ($i = 0; $i < $limit; $i++) {
            if ($this->rowIsEmpty($rows[$i]) || $this->rowLooksLikeData($rows[$i])) {
                continue;
            }

            $headerRow = array_map(fn ($h) => $this->normalizeHeader((string) $h), $rows[$i]);
            if (! $this->headerRowHasRequiredColumns($module, $headerRow, $rows, $i)) {
                continue;
            }

            $score = $this->scoreHeaderRow($module, $headerRow, $rows, $i) - ($i * 0.01);
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestIndex = $i;
            }
        }

        if ($bestIndex !== null) {
            return $bestIndex;
        }

        for ($i = 0; $i < $limit; $i++) {
            if ($this->rowIsEmpty($rows[$i]) || $this->rowLooksLikeData($rows[$i])) {
                continue;
            }

            $headerRow = array_map(fn ($h) => $this->normalizeHeader((string) $h), $rows[$i]);
            if ($this->resolveDocumentoFuzzyIndices($headerRow, [], $rows, $i) !== []) {
                return $i;
            }
        }

        return 0;
    }

    private function headerRowHasRequiredColumns(array $module, array $headerRow, array $rows, int $rowIndex): bool
    {
        $used = [];

        foreach ($module['columns'] as $columnDef) {
            if (! ($columnDef['required'] ?? false)) {
                continue;
            }

            $indices = $this->resolveColumnIndices($columnDef, $headerRow, $used, $rows, $rowIndex);
            if ($indices === [] && ($columnDef['key'] ?? '') === 'documento_identidad') {
                $indices = $this->resolveDocumentoFuzzyIndices($headerRow, $used, $rows, $rowIndex);
            }

            if ($indices === []) {
                return false;
            }

            foreach ($indices as $idx) {
                $used[] = $idx;
            }
        }

        return true;
    }

    private function scoreHeaderRow(array $module, array $headerRow, array $rows, int $rowIndex): int
    {
        $score = 0;
        $used = [];

        foreach ($module['columns'] as $columnDef) {
            $indices = $this->resolveColumnIndices($columnDef, $headerRow, $used, $rows, $rowIndex);
            if ($indices === [] && ($columnDef['key'] ?? '') === 'documento_identidad') {
                $indices = $this->resolveDocumentoFuzzyIndices($headerRow, $used, $rows, $rowIndex);
            }

            if ($indices === []) {
                continue;
            }

            foreach ($indices as $idx) {
                $used[] = $idx;
            }

            $score += ($columnDef['required'] ?? false) ? 10 : 1;
        }

        return $score;
    }

    private function rowLooksLikeData(array $row): bool
    {
        $signals = 0;

        foreach ($row as $cell) {
            $str = trim((string) $cell);
            if ($str === '') {
                continue;
            }

            $lower = mb_strtolower($str, 'UTF-8');
            if (in_array($lower, ['si', 'sí', 'no', '0', '1', 'true', 'false'], true)) {
                $signals += 2;
            }

            $digits = preg_replace('/\D+/', '', $str) ?? '';
            if ($digits !== '' && strlen($digits) >= 6 && strlen($digits) <= 10 && ctype_digit($digits)) {
                $signals += 2;
            }

            if ($this->looksLikePersonName($str)) {
                $signals += 3;
            }

            if (preg_match('/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}$/', $str)) {
                $signals += 2;
            }
        }

        return $signals >= 3;
    }

    private function looksLikePersonName(string $value): bool
    {
        return (bool) preg_match('/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s+[A-ZÁÉÍÓÚÑa-záéíóúñ][a-záéíóúñ]+)+$/u', $value);
    }

    private function missingRequiredColumnMessage(string $label, array $rows, int $headerRowIndex): string
    {
        $preview = [];
        $limit = min(count($rows), 4);

        for ($i = 0; $i < $limit; $i++) {
            $cells = array_map(
                fn ($cell) => trim((string) $cell),
                array_slice($this->padRow($rows[$i], 12), 0, 12)
            );
            $preview[] = 'Fila '.($i + 1).': '.implode(' | ', $cells);
        }

        return "Falta la columna obligatoria: {$label}. "
            .'Use la fila 1 para los encabezados (documento_identidad, nombre_completo, etc.) y datos desde la fila 2. '
            .'El sistema interpretó encabezados en la fila '.($headerRowIndex + 1).'. '
            .'Primeras filas del archivo: '.implode(' — ', $preview);
    }

    private function padRow(array $row, int $length): array
    {
        for ($i = 0; $i < $length; $i++) {
            if (! array_key_exists($i, $row)) {
                $row[$i] = null;
            }
        }

        return $row;
    }

    private function normalizeHeader(string $h): string
    {
        $h = preg_replace('/^\xEF\xBB\xBF/u', '', $h) ?? $h;
        $h = str_replace("\xc2\xa0", ' ', $h);
        $h = trim($h);
        if ($h === '') {
            return '';
        }

        $h = $this->foldAccents($h);
        $h = strtolower($h);
        $h = preg_replace('/[\s\-]+/u', '_', $h) ?? $h;
        $h = preg_replace('/[^a-z0-9_]/', '', $h) ?? $h;
        $h = preg_replace('/_+/', '_', $h) ?? $h;

        while (preg_match('/_(de|del|la|el|los|las)_/', $h)) {
            $h = preg_replace('/_(de|del|la|el|los|las)_/', '_', $h) ?? $h;
        }

        $h = preg_replace('/_+/', '_', $h) ?? $h;

        return trim($h, '_');
    }

    private function foldAccents(string $value): string
    {
        if (class_exists(\Transliterator::class)) {
            $transliterated = \Transliterator::create('Any-Latin; Latin-ASCII')->transliterate($value);
            if (is_string($transliterated) && $transliterated !== '') {
                return $transliterated;
            }
        }

        $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if ($converted !== false && trim($converted) !== '') {
            return $converted;
        }

        return strtr($value, [
            'Á' => 'A', 'À' => 'A', 'Ä' => 'A', 'Â' => 'A', 'Ã' => 'A',
            'É' => 'E', 'È' => 'E', 'Ë' => 'E', 'Ê' => 'E',
            'Í' => 'I', 'Ì' => 'I', 'Ï' => 'I', 'Î' => 'I',
            'Ó' => 'O', 'Ò' => 'O', 'Ö' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ú' => 'U', 'Ù' => 'U', 'Ü' => 'U', 'Û' => 'U',
            'Ñ' => 'N', 'Ç' => 'C',
            'á' => 'a', 'à' => 'a', 'ä' => 'a', 'â' => 'a', 'ã' => 'a',
            'é' => 'e', 'è' => 'e', 'ë' => 'e', 'ê' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'î' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ö' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'û' => 'u',
            'ñ' => 'n', 'ç' => 'c',
        ]);
    }

    private function cell(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_object($value) && method_exists($value, 'getPlainText')) {
            $value = $value->getPlainText();
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
