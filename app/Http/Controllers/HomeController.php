<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $leftImagePath;
    public $rightImagePath;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->leftImagePath = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/icon/logo.png')));
        // $this->rightImagePath = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('')));
    }   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Dashboard";

        \App\Support\ReposoEstatusSync::sincronizarFinalizados();
        
        // Estadísticas generales
        $totalOfficers = \App\Models\Oficiale::count();
        $operativos = \App\Models\Oficiale::where('estatus', 'Operativo')->count();
        $noOperativos = \App\Models\Oficiale::where('estatus', 'No Operativo')->count();
        $jubilados = \App\Models\Oficiale::where('estatus', 'Jubilado')->count();

        $totalPorTipo = $this->countsByTipo();
        $operativosPorTipo = $this->countsByTipo(fn ($q) => $q->where('estatus', 'Operativo'));
        $reposoPorTipo = $this->reposoCountsByTipo();
        
        // Funcionarios en reposo (vigentes)
        $funcionariosReposo = \App\Models\OficialesSalud::with('oficiale')
            ->whereIn('is_vigente', [1, 2])
            ->orderByRaw('fecha_reposo_fin IS NULL')
            ->orderBy('fecha_reposo_fin', 'asc')
            ->get();
        
        // Funcionarios en servicio (radiogramas activos)
        $funcionariosServicio = \App\Models\OficialesRadiograma::with(['oficiale', 'estacione'])
            ->where('is_actual', 1)
            ->orderBy('fecha_inicio', 'desc')
            ->get();
        
        // Notificaciones: Funcionarios que se reincorporan mañana
        $tomorrow = \Carbon\Carbon::tomorrow();
        $notificaciones = \App\Models\OficialesSalud::with('oficiale')
            ->where('is_vigente', 1)
            ->whereDate('fecha_reposo_fin', $tomorrow->format('Y-m-d'))
            ->get();
        
        return view('home', [
            'title' => $title,
            'leftImagePath' => $this->leftImagePath,
            'totalOfficers' => $totalOfficers,
            'operativos' => $operativos,
            'totalPorTipo' => $totalPorTipo,
            'operativosPorTipo' => $operativosPorTipo,
            'reposoPorTipo' => $reposoPorTipo,
            'noOperativos' => $noOperativos,
            'jubilados' => $jubilados,
            'funcionariosReposo' => $funcionariosReposo,
            'funcionariosServicio' => $funcionariosServicio,
            'notificaciones' => $notificaciones
        ]);
    }

    /**
     * @param  callable(\Illuminate\Database\Eloquent\Builder): void|null  $scope
     * @return array<string, int>
     */
    private function countsByTipo(?callable $scope = null): array
    {
        $query = \App\Models\Oficiale::query();
        if ($scope) {
            $scope($query);
        }

        $raw = $query
            ->selectRaw('tipo_funcionario, COUNT(*) as total')
            ->groupBy('tipo_funcionario')
            ->pluck('total', 'tipo_funcionario')
            ->all();

        return $this->normalizeTipoCounts($raw);
    }

    /**
     * @return array<string, int>
     */
    private function reposoCountsByTipo(): array
    {
        $raw = \App\Models\OficialesSalud::query()
            ->whereIn('is_vigente', [1, 2])
            ->join('oficiales', 'oficiales.id', '=', 'oficiales_salud.id_policia')
            ->selectRaw('oficiales.tipo_funcionario, COUNT(*) as total')
            ->groupBy('oficiales.tipo_funcionario')
            ->pluck('total', 'tipo_funcionario')
            ->all();

        return $this->normalizeTipoCounts($raw);
    }

    /**
     * @param  array<string|int, mixed>  $raw
     * @return array<string, int>
     */
    private function normalizeTipoCounts(array $raw): array
    {
        $counts = [];
        foreach (array_values(\App\Models\Oficiale::TIPOS_FUNCIONARIO) as $tipo) {
            $counts[$tipo] = (int) ($raw[$tipo] ?? 0);
        }

        foreach ($raw as $tipo => $total) {
            $label = (string) $tipo;
            if (! array_key_exists($label, $counts)) {
                $counts[$label] = (int) $total;
            }
        }

        return $counts;
    }

    public function officers()
    {
        $title = "Funcionarios Policiales";
        return view('admin.officers.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath]);
    }

    public function officers_academy($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Datos académicos";
        return view('admin.officers-academy.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_position($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Jerarquías obtenidas";
        return view('admin.officers-position.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_familly($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Familiares";
        return view('admin.officers-family.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_vacations($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Vacaciones - Años de servicio: " . (now()->year - $o->fecha_ingreso->year);
        return view('admin.officers-vacations.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_courses($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Cursos y diplomados";
        return view('admin.officers-courses.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_awards($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Reconocimientos";
        return view('admin.officers-awards.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_radiogram($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Radiograma";
        return view('admin.officers-radiogram.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_health($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - Reposos Médicos";
        return view('admin.officers-health.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id'=>$id]);
    }

    public function officers_icap($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Funcionario Policial: " . $o->nombre_completo . " - ICAP";
        return view('admin.officers-icap.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath, 'id' => $id]);
    }

    public function officers_urra($id)
    {
        $o = \App\Models\Oficiale::findOrFail($id);
        $title = 'Funcionario: '.$o->nombre_completo.' - URRA';

        return view('admin.officers-urra.index', [
            'title' => $title,
            'leftImagePath' => $this->leftImagePath,
            'id' => $id,
        ]);
    }

    // Métodos de vistas de configuración
    public function stations()
    {
        $title = "Estaciones de comando";
        return view('admin.stations.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath]);
    }

    public function users()
    {
        $title = "Usuarios";
        return view('admin.users.index', ['title' => $title, 'leftImagePath' => $this->leftImagePath]);
    }

    public function config_discapacidades()
    {
        return view('admin.config.catalogo', [
            'title' => 'Discapacidades',
            'subtitle' => 'Catálogo usado en familiares de funcionarios',
            'singular' => 'discapacidad',
            'placeholder' => 'Ejemplo: Visual, Motora, Auditiva…',
            'apiEndpoint' => '/discapacidades',
            'leftImagePath' => $this->leftImagePath,
        ]);
    }

    public function config_cursos()
    {
        return view('admin.config.catalogo', [
            'title' => 'Cursos y diplomados',
            'subtitle' => 'Catálogo de nombres usados en cursos y diplomados de funcionarios',
            'singular' => 'curso / diplomado',
            'placeholder' => 'Ejemplo: Criminalística y penalidad',
            'apiEndpoint' => '/catalogo-cursos',
            'leftImagePath' => $this->leftImagePath,
        ]);
    }

    public function config_cargos()
    {
        return view('admin.config.catalogo', [
            'title' => 'Cargos',
            'subtitle' => 'Jerarquías policiales usadas en el historial de cargos del funcionario',
            'singular' => 'cargo',
            'placeholder' => 'Ejemplo: Inspector, Comisario…',
            'apiEndpoint' => '/cargos',
            'leftImagePath' => $this->leftImagePath,
        ]);
    }

    public function config_cargos_administrativos()
    {
        return view('admin.config.catalogo', [
            'title' => 'Cargos administrativos',
            'subtitle' => 'Catálogo del cargo del funcionario (el tipo Policial / Administrativo / Obrero se define al crear el funcionario)',
            'singular' => 'cargo administrativo',
            'placeholder' => 'Ejemplo: Asistente administrativo, Mecánico…',
            'apiEndpoint' => '/cargos-administrativos',
            'leftImagePath' => $this->leftImagePath,
        ]);
    }
}
