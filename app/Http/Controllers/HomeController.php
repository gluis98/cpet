<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Inicio";
        return view('home', compact('title'));
    }

    public function users()
    {
        $title = "Usuarios";
        return view('admin.users.index', compact('title'));
    }

    public function officers()
    {
        $title = "Oficiales";
        return view('admin.officers.index', compact('title'));
    }

    public function officers_academy($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Datos académicos";
        return view('admin.officers-academy.index', compact('title', 'id'));
    }

    public function officers_position($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Cargos alcanzados";
        return view('admin.officers-position.index', compact('title', 'id'));
    }

    public function officers_familly($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Familiares";
        return view('admin.officers-family.index', compact('title', 'id'));
    }

    public function officers_vacations($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Vacaciones - Años de servicio: " . (now()->year - $o->fecha_ingreso->year);
        return view('admin.officers-vacations.index', compact('title', 'id'));
    }

    public function officers_courses($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Cursos y diplomados";
        return view('admin.officers-courses.index', compact('title', 'id'));
    }

    public function officers_awards($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Reconocimientos";
        return view('admin.officers-awards.index', compact('title', 'id'));
    }

    public function officers_armament($id)
    {
        $o = \App\Models\Oficiale::find($id);
        $title = "Oficial: " . $o->nombre_completo . " - Armamento";
        return view('admin.officers-armament.index', compact('title', 'id'));
    }
}
