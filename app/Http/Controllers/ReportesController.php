<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use App\Models\OficialesVacacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function officers_cargo(Request $request)
    {
        // Inicializar la consulta
        $query = Oficiale::query()->with('oficiales_cargos.cargo');

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
        // Inicializar la consulta
        $query = Oficiale::query()->with('oficiales_familiares');

        // Depurar los valores recibidos
        Log::info('Filtros recibidos: ', [
            'parentesco' => $request->parentesco,
            'fecha_nacimiento_inicio' => $request->fecha_nacimiento_inicio,
            'fecha_nacimiento_fin' => $request->fecha_nacimiento_fin,
        ]);

        // Aplicar todos los filtros dentro de un solo whereHas
        $query->whereHas('oficiales_familiares', function ($q) use ($request) {
            // Filtrar por Parentesco
            if ($request->has('parentesco') && !empty($request->parentesco)) {
                $q->where('parentesco', $request->parentesco);
            }

            // Filtrar por Fecha de Nacimiento (rango) usando whereBetween
            if ($request->has('fecha_nacimiento_inicio') && !empty($request->fecha_nacimiento_inicio)) {
                $startDate = $request->fecha_nacimiento_inicio;
                $endDate = $request->has('fecha_nacimiento_fin') && !empty($request->fecha_nacimiento_fin)
                    ? $request->fecha_nacimiento_fin
                    : $startDate; // Si no hay fin, usa la fecha de inicio como límite
                $q->whereBetween('fecha_nacimiento', [$startDate, $endDate]);
                Log::info('Filtro aplicado: fecha_nacimiento BETWEEN ' . $startDate . ' AND ' . $endDate);
            }
        });

        // Obtener los resultados
        $oficiales = $query->get();

        // Depurar los resultados
        Log::info('Resultados obtenidos: ', $oficiales->map(function ($oficial) {
            return [
                'id' => $oficial->id,
                'familiares' => $oficial->oficiales_familiares->map(function ($familiar) {
                    return ['nombre' => $familiar->nombre_completo, 'fecha_nacimiento' => $familiar->fecha_nacimiento];
                })->all(),
            ];
        })->all());

        // Pasar los datos a la vista
        return view('admin.reports.familly', compact('oficiales'));
    }
}
