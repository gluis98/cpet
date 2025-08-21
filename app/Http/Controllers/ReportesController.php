<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use App\Models\OficialesVacacione;
use App\Models\Entidad;
use App\Models\OficialesRadiograma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportesController extends Controller
{
    protected $entidad;

    public function __construct(Entidad $entidad)
    {
        $this->entidad = Entidad::first();
    }

    // Esta función sirve para obtener el reporte individual de la boleta de vacaciones de un oficial
    public function vacation($id)
    {
        $oficial = OficialesVacacione::with('oficiale')->findOrFail($id);
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
        return view('admin.reports.vacation', ['oficial' => $oficial, 'title' => 'BOLETA DE VACACIONES', 'tipo' => 'VACACIONES DEL AÑO ' . $anio . " CON " . $dias_habiles . " DÍAS HÁBILES", 'entidad' => $this->entidad]);
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
        return view('admin.reports.radiogram', ['oficial' => $oficial, 'title' => '', 'tipo' => 'VACACIONES DEL AÑO ' . $anio . " CON " . $dias_habiles . " DÍAS HÁBILES", 'entidad' => $this->entidad]);
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
        // Validar los datos de entrada
        // $request->validate([
        //     'parentesco' => 'nullable|string|max:255',
        //     'fecha_nacimiento_inicio' => 'nullable|date|date_format:Y-m-d',
        //     'fecha_nacimiento_fin' => 'nullable|date|date_format:Y-m-d|after_or_equal:fecha_nacimiento_inicio',
        // ]);

        // Inicializar la consulta
        $query = Oficiale::query()->with(['oficiales_familiares' => function ($q) use ($request) {
            // Filtrar por parentesco
            if ($request->filled('parentesco')) {
                $q->where('parentesco', $request->parentesco);
            }

            // Filtrar por fecha de nacimiento
            $startDate = $request->filled('fecha_nacimiento_inicio') 
                ? $request->fecha_nacimiento_inicio 
                : '2015-01-01'; // Por defecto: desde 2015

            $endDate = $request->filled('fecha_nacimiento_fin') 
                ? $request->fecha_nacimiento_fin 
                : now()->format('Y-m-d'); // Por defecto: hasta hoy

            // Asegurar que startDate no sea anterior a 2015
            if (strtotime($startDate) < strtotime('2015-01-01')) {
                $startDate = '2015-01-01';
            }

            // Aplicar filtro de fecha con whereBetween
            $q->whereBetween('fecha_nacimiento', [$startDate, $endDate]);

            // Condición explícita para excluir fechas anteriores a 2015
            $q->where('fecha_nacimiento', '>=', '2015-01-01');

            // Depurar el filtro de fechas
            Log::info('Filtro de fechas aplicado en oficiales_familiares: ', [
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        }]);

        // Filtrar oficiales que tengan familiares que cumplan con los criterios
        $query->whereHas('oficiales_familiares', function ($q) use ($request) {
            // Repetir los mismos filtros para whereHas
            if ($request->filled('parentesco')) {
                $q->where('parentesco', $request->parentesco);
            }

            $startDate = $request->filled('fecha_nacimiento_inicio') 
                ? $request->fecha_nacimiento_inicio 
                : '2015-01-01';

            $endDate = $request->filled('fecha_nacimiento_fin') 
                ? $request->fecha_nacimiento_fin 
                : now()->format('Y-m-d');

            if (strtotime($startDate) < strtotime('2015-01-01')) {
                $startDate = '2015-01-01';
            }

            $q->whereBetween('fecha_nacimiento', [$startDate, $endDate]);
            $q->where('fecha_nacimiento', '>=', '2015-01-01');
        });

        // Depurar los valores recibidos
        Log::info('Filtros recibidos: ', [
            'parentesco' => $request->parentesco,
            'fecha_nacimiento_inicio' => $request->fecha_nacimiento_inicio,
            'fecha_nacimiento_fin' => $request->fecha_nacimiento_fin,
        ]);

        // Depurar la consulta SQL generada
        Log::info('Consulta SQL: ', [
            'query' => $query->toSql(),
            'bindings' => $query->getBindings(),
        ]);

        // Obtener los resultados
        $oficiales = $query->get();

        // Depurar los resultados
        Log::info('Resultados obtenidos: ', $oficiales->map(function ($oficial) {
            return [
                'id' => $oficial->id,
                'nombre' => $oficial->nombre_completo,
                'documento' => $oficial->documento_identidad,
                'familiares' => $oficial->oficiales_familiares->map(function ($familiar) {
                    return [
                        'nombre' => $familiar->nombre_completo,
                        'fecha_nacimiento' => $familiar->fecha_nacimiento,
                        'parentesco' => $familiar->parentesco,
                        'sexo' => $familiar->sexo,
                        'edad' => $familiar->edad,
                    ];
                })->all(),
            ];
        })->all());

        // Pasar los datos a la vista
        return view('admin.reports.familly', compact('oficiales'));
    }
}
