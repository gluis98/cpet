<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use App\Models\OficialesVacacione;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    // Esta función sirve para obtener el reporte individual de la boleta de vacaciones de un oficial
    public function vacation($id)
    {
        $oficial = OficialesVacacione::with('oficiale')->findOrFail($id);
        return view('admin.reports.vacation');
    }

    public function card(Request $request)
    {
        $oficial = Oficiale::where('documento_identidad', $request->documento_identidad)->orderBy('documento_identidad')->first();
        return view('admin.reports.card', ['officer' => $oficial]);
    }  

    public function officers()
    {
        $oficial = Oficiale::orderBy('documento_identidad')->get();
        return view('admin.reports.officers', ['oficiales' => $oficial]);
    }  

    public function officers_born_date(Request $request)
    {   
        $oficial = Oficiale::whereBetween('fecha_nacimiento', [$request->fechaInicio, $request->fechaFin])->orderBy('documento_identidad')->get();

        if($request->fechaInicio == $request->fechaFin){
            $oficial = Oficiale::where('fecha_nacimiento', $request->fechaInicio)->orderBy('documento_identidad')->get();
        }

        return view('admin.reports.officers', ['oficiales' => $oficial]);
    }

    public function ingress_date(Request $request)
    {   
        $oficial = Oficiale::whereBetween('fecha_ingreso', [$request->fechaInicio, $request->fechaFin])->orderBy('documento_identidad')->get();

        if($request->fechaInicio == $request->fechaFin){
            $oficial = Oficiale::where('fecha_ingreso', $request->fechaInicio)->orderBy('documento_identidad')->get();
        }

        return view('admin.reports.officers', ['oficiales' => $oficial]);
    }


}
