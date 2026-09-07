<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use App\Models\OficialesVacacione;
use App\Support\VacacionesPeriodos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OfficersVacationsController extends Controller
{
    public function index($id)
    {
        $this->marcarDisfrutadasPorReintegro((int) $id);
        VacacionesPeriodos::dedupeOficial((int) $id);

        $oficial = Oficiale::find((int) $id);
        $vacaciones = OficialesVacacione::where('id_policia', $id)
            ->orderByRaw('fecha_emision IS NULL')
            ->orderByDesc('fecha_emision')
            ->orderByDesc('id')
            ->get();

        $resumen = VacacionesPeriodos::resumen($oficial, $vacaciones);

        return response()->json([
            'data' => $vacaciones,
            'counts' => [
                'anios_servicio' => $resumen['anios_servicio'],
                'disfrutadas' => $resumen['disfrutadas'],
                'vencidas' => $resumen['vencidas'],
                'total' => $resumen['total'],
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request);
        $this->assertAnioUnico((int) $data['id_policia'], $data['fecha_emision']);

        $vacacion = OficialesVacacione::create($data);

        if ($vacacion->id_policia) {
            $this->marcarDisfrutadasPorReintegro((int) $vacacion->id_policia);
            VacacionesPeriodos::dedupeOficial((int) $vacacion->id_policia);
        }

        return response()->json(['msj' => 'Registro realizado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(OficialesVacacione::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $vacacion = OficialesVacacione::findOrFail($id);
        $data = $this->payload($request, $vacacion);
        $idPolicia = (int) ($data['id_policia'] ?? $vacacion->id_policia);
        $this->assertAnioUnico($idPolicia, $data['fecha_emision'], (int) $vacacion->id);

        $vacacion->update($data);

        if ($vacacion->id_policia) {
            $this->marcarDisfrutadasPorReintegro((int) $vacacion->id_policia);
            VacacionesPeriodos::dedupeOficial((int) $vacacion->id_policia);
        }

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        OficialesVacacione::destroy($id);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function marcarDisfrutadasPorReintegro(int $idPolicia): void
    {
        $hoy = Carbon::today()->toDateString();

        OficialesVacacione::where('id_policia', $idPolicia)
            ->whereNotNull('fecha_reintegro')
            ->whereDate('fecha_reintegro', '<=', $hoy)
            ->where(function ($q) {
                $q->whereNull('is_disfrutadas')
                    ->orWhere('is_disfrutadas', 0);
            })
            ->update(['is_disfrutadas' => 1]);
    }

    private function payload(Request $request, ?OficialesVacacione $existing = null): array
    {
        $data = $request->validate([
            'id_policia' => [$existing ? 'sometimes' : 'required', 'integer'],
            'fecha_emision' => ['required', 'date'],
            'fecha_hasta' => ['nullable', 'date', 'after_or_equal:fecha_emision'],
            'fecha_reintegro' => ['nullable', 'date'],
            'estatus' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'is_disfrutadas' => ['nullable'],
        ]);

        $data['estatus'] = strtoupper(trim($data['estatus']));
        if ($data['estatus'] === 'EN PROCESO') {
            throw ValidationException::withMessages([
                'estatus' => 'El estatus EN PROCESO ya no está permitido.',
            ]);
        }

        $data['is_disfrutadas'] = $request->boolean('is_disfrutadas') ? 1 : 0;

        if (! empty($data['fecha_reintegro']) && Carbon::parse($data['fecha_reintegro'])->lte(Carbon::today())) {
            $data['is_disfrutadas'] = 1;
        }

        return $data;
    }

    private function assertAnioUnico(int $idPolicia, string $fechaEmision, ?int $ignoreId = null): void
    {
        $anio = (int) Carbon::parse($fechaEmision)->format('Y');
        $query = OficialesVacacione::query()
            ->where('id_policia', $idPolicia)
            ->whereYear('fecha_emision', $anio);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'fecha_emision' => "Ya existe un periodo de vacaciones para el año {$anio}. Solo se permite uno por año de servicio.",
            ]);
        }
    }
}
