<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargosAdministrativo;
use App\Models\Oficiale;
use App\Models\OficialesUrra;
use App\Models\OficialesVacacione;
use App\Models\Entidad;
use App\Models\OficialesRadiograma;
use App\Support\UrraEstatusSync;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportesController extends Controller
{
    protected function entidad(): Entidad
    {
        $entidad = Entidad::query()->first();
        if (! $entidad) {
            $entidad = Entidad::create([
                'director_general' => null,
                'rrhh' => null,
            ]);
        }

        return $entidad;
    }

    // Esta función sirve para obtener el reporte individual de la boleta de vacaciones de un oficial
    public function vacation($id)
    {
        $oficial = OficialesVacacione::with('oficiale')->findOrFail($id);
        $anio = Carbon::parse($oficial->fecha_emision)->format('Y');
        $dias = 0;
        $fechaInicio = Carbon::parse($oficial->fecha_emision);
        $fechaFinRaw = $oficial->fecha_hasta ?? $oficial->fecha_reintegro;
        $fechaFin = $fechaFinRaw ? Carbon::parse($fechaFinRaw) : Carbon::now();
        while ($fechaInicio->lte($fechaFin)) {
            if ($fechaInicio->isWeekday()) {
                $dias++;
            }
            $fechaInicio->addDay();
        }
        $dias_habiles = $dias;
        return view('admin.reports.vacation', ['oficial' => $oficial, 'title' => 'BOLETA DE VACACIONES', 'tipo' => 'VACACIONES DEL AÑO ' . $anio . " CON " . $dias_habiles . " DÍAS HÁBILES", 'entidad' => $this->entidad()]);
    }

    public function radiogram($id)
    {
        $oficial = OficialesRadiograma::findOrFail($id);
        $anio = Carbon::parse($oficial->fecha_emision)->format('Y');
        $dias = 0;
        $fechaInicio = Carbon::parse($oficial->fecha_emision);
        $fechaFin = isset($oficial->fecha_reintegro) ? Carbon::parse($oficial->fecha_reintegro) : Carbon::now();
        while ($fechaInicio->lte($fechaFin)) {
            if ($fechaInicio->isWeekday()) {
                $dias++;
            }
            $fechaInicio->addDay();
        }
        $dias_habiles = $dias;
        return view('admin.reports.radiogram', ['oficial' => $oficial, 'title' => '', 'tipo' => 'VACACIONES DEL AÑO ' . $anio . " CON " . $dias_habiles . " DÍAS HÁBILES", 'entidad' => $this->entidad()]);
    }

    public function card(Request $request)
    {
        $oficial = Oficiale::with('cargos_administrativo')->where('documento_identidad', $request->documento_identidad)->orderBy('documento_identidad')->first();
        return view('admin.reports.card', ['officer' => $oficial]);
    }  

    public function officers()
    {
        $oficial = Oficiale::with('cargos_administrativo')->orderBy('documento_identidad')->get();
        return view('admin.reports.officers', ['oficiales' => $oficial]);
    }  

    public function officers_born_date(Request $request)
    {   
        $oficial = Oficiale::with('cargos_administrativo')->whereBetween('fecha_nacimiento', [$request->fechaInicio, $request->fechaFin])->orderBy('documento_identidad')->get();

        if($request->fechaInicio == $request->fechaFin){
            $oficial = Oficiale::with('cargos_administrativo')->where('fecha_nacimiento', $request->fechaInicio)->orderBy('documento_identidad')->get();
        }

        return view('admin.reports.officers', ['oficiales' => $oficial]);
    }

    public function ingress_date(Request $request)
    {   
        $oficial = Oficiale::with('cargos_administrativo')->whereBetween('fecha_ingreso', [$request->fechaInicio, $request->fechaFin])->orderBy('documento_identidad')->get();

        if($request->fechaInicio == $request->fechaFin){
            $oficial = Oficiale::with('cargos_administrativo')->where('fecha_ingreso', $request->fechaInicio)->orderBy('documento_identidad')->get();
        }

        return view('admin.reports.officers', ['oficiales' => $oficial]);
    }

    public function officers_cargo(Request $request)
    {
        // Inicializar la consulta
        $query = Oficiale::query()->with('oficiales_cargos.cargo', 'cargos_administrativo');

        // Filtrar por ID de cargo (si está presente)
        if ($request->has('id_cargo') && !empty($request->id_cargo) && $request->id_cargo != "") {
            $query->whereHas('oficiales_cargos', function ($q) use ($request) {
                $q->where('id_cargo', $request->id_cargo);
            });
        }

        // Filtrar por Fecha Inicio (si está presente)
        if ($request->has('fechaInicio') && !empty($request->fechaInicio)) {
            $query->whereHas('oficiales_cargos', function ($q) use ($request) {
                $q->where('fecha_inicio', '>=', $request->fechaInicio);
            });
        }

        // Filtrar por Fecha Fin (si está presente)
        if ($request->has('fechaFin') && !empty($request->fechaFin)) {
            $query->whereHas('oficiales_cargos', function ($q) use ($request) {
                $q->where('fecha_fin', '<=', $request->fechaFin)
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('fecha_fin', null)
                          ->where('is_actual', 1)
                          ->where('fecha_inicio', '<=', $request->fechaFin);
                  });
            });
        }

        // Obtener los resultados
        $oficiales = $query->get();

        // Pasar los datos a la vista
        return view('admin.reports.officers', compact('oficiales'));
    }

    public function family_members(Request $request)
    {
        $query = Oficiale::query()
            ->with([
                'oficiales_familiares' => fn ($q) => $this->applyFamiliaresReportFilters($q, $request),
                'oficiales_familiares.discapacidade',
            ])
            ->whereHas('oficiales_familiares', fn ($q) => $this->applyFamiliaresReportFilters($q, $request))
            ->orderBy('nombre_completo');

        $oficiales = $query->get();
        $totalFamiliares = $oficiales->sum(fn ($o) => $o->oficiales_familiares->count());

        return view('admin.reports.familly', [
            'oficiales' => $oficiales,
            'filtros' => $this->describeFamiliaresFilters($request),
            'totalFamiliares' => $totalFamiliares,
            'entidad' => $this->entidad(),
        ]);
    }

    private function applyFamiliaresReportFilters($query, Request $request): void
    {
        if ($request->filled('parentesco')) {
            $query->where('parentesco', $request->parentesco);
        }

        if ($request->filled('fecha_nacimiento_inicio') || $request->filled('fecha_nacimiento_fin')) {
            $startDate = $request->filled('fecha_nacimiento_inicio')
                ? $request->fecha_nacimiento_inicio
                : '1900-01-01';

            $endDate = $request->filled('fecha_nacimiento_fin')
                ? $request->fecha_nacimiento_fin
                : now()->format('Y-m-d');

            if (strtotime($startDate) > strtotime($endDate)) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $query->whereNotNull('fecha_nacimiento')
                ->whereDate('fecha_nacimiento', '>=', $startDate)
                ->whereDate('fecha_nacimiento', '<=', $endDate);
        }

        if ($request->filled('edad_min') || $request->filled('edad_max')) {
            $edadMin = $request->filled('edad_min') ? max(0, (int) $request->edad_min) : null;
            $edadMax = $request->filled('edad_max') ? max(0, (int) $request->edad_max) : null;

            if ($edadMin !== null && $edadMax !== null && $edadMin > $edadMax) {
                [$edadMin, $edadMax] = [$edadMax, $edadMin];
            }

            $query->where(function ($q) use ($edadMin, $edadMax) {
                $q->where(function ($sub) use ($edadMin, $edadMax) {
                    $sub->whereNotNull('fecha_nacimiento');

                    if ($edadMin !== null) {
                        $sub->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= ?', [$edadMin]);
                    }
                    if ($edadMax !== null) {
                        $sub->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= ?', [$edadMax]);
                    }
                })->orWhere(function ($sub) use ($edadMin, $edadMax) {
                    $sub->whereNull('fecha_nacimiento')->whereNotNull('edad');

                    if ($edadMin !== null) {
                        $sub->where('edad', '>=', $edadMin);
                    }
                    if ($edadMax !== null) {
                        $sub->where('edad', '<=', $edadMax);
                    }
                });
            });
        }
    }

    private function describeFamiliaresFilters(Request $request): array
    {
        $labels = [];

        if ($request->filled('parentesco')) {
            $labels[] = 'Parentesco: '.$request->parentesco;
        }
        if ($request->filled('fecha_nacimiento_inicio')) {
            $labels[] = 'Nacimiento desde: '.Carbon::parse($request->fecha_nacimiento_inicio)->format('d/m/Y');
        }
        if ($request->filled('fecha_nacimiento_fin')) {
            $labels[] = 'Nacimiento hasta: '.Carbon::parse($request->fecha_nacimiento_fin)->format('d/m/Y');
        }
        if ($request->filled('edad_min') && $request->filled('edad_max') && (int) $request->edad_min === (int) $request->edad_max) {
            $labels[] = 'Edad: '.(int) $request->edad_min.' años';
        } else {
            if ($request->filled('edad_min')) {
                $labels[] = 'Edad desde: '.(int) $request->edad_min.' años';
            }
            if ($request->filled('edad_max')) {
                $labels[] = 'Edad hasta: '.(int) $request->edad_max.' años';
            }
        }

        return $labels;
    }

    public function sizes(Request $request)
    {
        $query = Oficiale::query()->with('cargos_administrativo');

        // Campos simples
        $campos = [
            'tipo_sangre',
            'estado_civil',
            'talla_camisa',
            'talla_pantalon',
            'talla_zapato',
            'talla_saco',
            'talla_kepin_toka',
            'talla_tacon',
            'talla_falda',
            'talla_gorra',
        ];

        foreach ($campos as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, $request->$campo);
            }
        }

        $oficiales = $query->get();

        return view('admin.reports.officers', compact('oficiales'));
    }

    /**
     * Reporte con filtros avanzados (sexo, sangre, hijos, vivienda, conducción, etc.).
     */
    public function officersFiltered(Request $request)
    {
        $query = $this->buildOfficersFilterQuery($request);

        $query->withCount(['oficiales_familiares as hijos_count' => fn ($q) => $q->where('parentesco', 'Hijo(a)')]);

        if ($request->filled('cantidad_hijos')) {
            $cant = $request->cantidad_hijos;
            if ($cant === '4+') {
                $query->having('hijos_count', '>=', 4);
            } else {
                $query->having('hijos_count', '=', (int) $cant);
            }
        }

        $oficiales = $query
            ->with([
                'cargos_administrativo',
                'oficiales_cargos' => fn ($q) => $q->where('is_actual', 1)->with('cargo'),
                'oficiales_academicos' => fn ($q) => $q->orderByDesc('fecha_fin')->orderByDesc('id'),
            ])
            ->withCount(['oficiales_familiares as hijos_count' => fn ($q) => $q->where('parentesco', 'Hijo(a)')])
            ->orderBy('nombre_completo')
            ->get();

        return view('admin.reports.officers-filtered', [
            'oficiales' => $oficiales,
            'filtros' => $this->describeAppliedFilters($request),
        ]);
    }

    private function buildOfficersFilterQuery(Request $request)
    {
        $query = Oficiale::query();

        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        if ($request->filled('tipo_sangre')) {
            $query->where('tipo_sangre', $request->tipo_sangre);
        }

        if ($request->filled('estado_civil')) {
            $query->where('estado_civil', $request->estado_civil);
        }

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->filled('tipo_funcionario')) {
            $query->where('tipo_funcionario', $request->tipo_funcionario);
        }

        if ($request->filled('cargo_administrativo_id')) {
            $query->where('cargo_administrativo_id', $request->cargo_administrativo_id);
        }

        if ($request->filled('tipo_vivienda')) {
            $query->where('tipo_vivienda', $request->tipo_vivienda);
        }

        if ($request->filled('posee_vivienda')) {
            if ($request->posee_vivienda === 'si') {
                $query->whereNotNull('tipo_vivienda')->where('tipo_vivienda', '!=', 'No posee');
            } elseif ($request->posee_vivienda === 'no') {
                $query->where(function ($q) {
                    $q->whereNull('tipo_vivienda')->orWhere('tipo_vivienda', 'No posee');
                });
            }
        }

        if ($request->filled('sabe_conducir')) {
            $query->where('sabe_conducir', $request->sabe_conducir === '1');
        }

        if ($request->filled('tipo_conduccion')) {
            $tipo = $request->tipo_conduccion;
            $query->where('sabe_conducir', true)
                ->where(function ($q) use ($tipo) {
                    $q->whereJsonContains('tipos_conduccion', $tipo)
                        ->orWhere('tipos_conduccion', 'like', '%"'.$tipo.'"%');
                });
        }

        if ($request->filled('id_cargo')) {
            $query->whereHas('oficiales_cargos', function ($q) use ($request) {
                $q->where('id_cargo', $request->id_cargo);
                if ($request->boolean('jerarquia_actual')) {
                    $q->where('is_actual', 1);
                }
            });
        }

        if ($request->filled('tipo_formacion')) {
            $query->whereHas('oficiales_academicos', fn ($q) => $q->where('tipo_formacion', $request->tipo_formacion));
        }

        return $query;
    }

    private function describeAppliedFilters(Request $request): array
    {
        $labels = [];

        if ($request->filled('sexo')) {
            $labels[] = 'Sexo: '.$request->sexo;
        }
        if ($request->filled('tipo_sangre')) {
            $labels[] = 'Tipo de sangre: '.$request->tipo_sangre;
        }
        if ($request->filled('estado_civil')) {
            $labels[] = 'Estado civil: '.$request->estado_civil;
        }
        if ($request->filled('cantidad_hijos')) {
            $labels[] = 'Cantidad de hijos: '.$request->cantidad_hijos;
        }
        if ($request->filled('tipo_funcionario')) {
            $labels[] = 'Tipo de funcionario: '.$request->tipo_funcionario;
        }
        if ($request->filled('cargo_administrativo_id')) {
            $cargo = CargosAdministrativo::find($request->cargo_administrativo_id);
            $labels[] = 'Cargo: '.($cargo->nombre_cargo ?? $request->cargo_administrativo_id);
        }
        if ($request->filled('estatus')) {
            $labels[] = 'Estatus: '.$request->estatus;
        }
        if ($request->filled('id_cargo')) {
            $jer = Cargo::find($request->id_cargo);
            $labels[] = 'Jerarquía: '.($jer->nombre_cargo ?? $request->id_cargo)
                .($request->boolean('jerarquia_actual') ? ' (actual)' : '');
        }
        if ($request->filled('tipo_formacion')) {
            $labels[] = 'Formación académica: '.$request->tipo_formacion;
        }
        if ($request->filled('posee_vivienda')) {
            $labels[] = 'Posee vivienda: '.($request->posee_vivienda === 'si' ? 'Sí' : 'No');
        }
        if ($request->filled('tipo_vivienda')) {
            $labels[] = 'Tipo de vivienda: '.$request->tipo_vivienda;
        }
        if ($request->filled('sabe_conducir')) {
            $labels[] = 'Sabe conducir: '.($request->sabe_conducir === '1' ? 'Sí' : 'No');
        }
        if ($request->filled('tipo_conduccion')) {
            $labels[] = 'Tipo de vehículo: '.$request->tipo_conduccion;
        }

        return $labels;
    }

    /**
     * Ficha individual de un registro URRA.
     */
    public function urraFicha($id)
    {
        UrraEstatusSync::sincronizarVencidos();

        $urra = OficialesUrra::with([
            'oficiale.cargos_administrativo',
            'oficiale.oficiales_cargos' => function ($q) {
                $q->where('is_actual', 1)->with('cargo');
            },
            'oficiale.armamentos',
        ])->findOrFail($id);
        $logos = $this->urraLogos();

        return view('admin.reports.urra-ficha', [
            'urra' => $urra,
            'officer' => $urra->oficiale,
            'logos' => $logos,
        ]);
    }

    /**
     * Funcionarios que alguna vez han tenido URRA.
     */
    public function urraHistorial()
    {
        UrraEstatusSync::sincronizarVencidos();

        $registros = OficialesUrra::with(['oficiale.cargos_administrativo'])
            ->orderByDesc('fecha_inicio')
            ->get();

        return view('admin.reports.urra-list', [
            'title' => 'Funcionarios que han asistido a URRA',
            'subtitle' => 'Historial completo de asignaciones URRA',
            'modo' => 'historial',
            'registros' => $registros,
        ]);
    }

    /**
     * Funcionarios actualmente en URRA.
     */
    public function urraActuales()
    {
        UrraEstatusSync::sincronizarVencidos();

        $registros = OficialesUrra::with(['oficiale.cargos_administrativo'])
            ->where('en_servicio', true)
            ->orderByDesc('fecha_inicio')
            ->get();

        return view('admin.reports.urra-list', [
            'title' => 'Funcionarios actualmente en URRA',
            'subtitle' => 'Asignaciones con servicio activo',
            'modo' => 'actuales',
            'registros' => $registros,
        ]);
    }

    /**
     * Logos del cintillo en public/img/urra ordenados numéricamente (1, 2, 3…).
     */
    private function urraLogos(): array
    {
        $dir = public_path('img/urra');
        if (! File::isDirectory($dir)) {
            return [];
        }

        $files = collect(File::files($dir))
            ->filter(function ($file) {
                $ext = strtolower($file->getExtension());

                return in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg'], true);
            })
            ->sortBy(function ($file) {
                preg_match('/^(\d+)/', $file->getFilename(), $m);

                return isset($m[1]) ? (int) $m[1] : PHP_INT_MAX;
            })
            ->values();

        return $files->map(fn ($file) => asset('img/urra/'.$file->getFilename()))->all();
    }
}
