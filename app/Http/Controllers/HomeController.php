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
        $title = "Inicio";
        return view('home', ['title' => $title, 'leftImagePath' => $this->leftImagePath]);
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
}
