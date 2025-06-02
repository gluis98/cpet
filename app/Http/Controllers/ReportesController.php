<?php

namespace App\Http\Controllers;

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
}
