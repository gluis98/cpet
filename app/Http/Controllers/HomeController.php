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
}
