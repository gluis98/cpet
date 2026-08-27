<?php

namespace App\Http\Controllers;

use App\Models\OficialesVacacione;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfficersVacationsController extends Controller
{
    public function index($id)
    {
        $this->marcarDisfrutadasPorReintegro((int) $id);

        $vacaciones = OficialesVacacione::where('id_policia', $id)
            ->orderByRaw('fecha_emision IS NULL')
            ->orderByDesc('fecha_emision')
            ->orderByDesc('id')
            ->get();

        $counts = [
            'disfrutadas' => $vacaciones->where('is_disfrutadas', 1)->count(),
            'en_proceso' => $vacaciones->filter(fn ($v) => $this->esEnProceso($v))->count(),
            'vencidas' => $vacaciones->filter(fn ($v) => $this->esVencida($v))->count(),
            'total' => $vacaciones->count(),
        ];

        return response()->json([
            'data' => $vacaciones,
            'counts' => $counts,
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request);
        $vacacion = OficialesVacacione::create($data);

        if ($vacacion->id_policia) {
            $this->marcarDisfrutadasPorReintegro((int) $vacacion->id_policia);
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
        $vacacion->update($this->payload($request));

        if ($vacacion->id_policia) {
            $this->marcarDisfrutadasPorReintegro((int) $vacacion->id_policia);
        }

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        OficialesVacacione::destroy($id);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    /**
     * Si la fecha de reintegro ya llegó o pasó, marcar como disfrutadas.
     */
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

    private function payload(Request $request): array
    {
        $data = $request->validate([
            'id_policia' => ['sometimes', 'integer'],
            'fecha_emision' => ['required', 'date'],
            'fecha_reintegro' => ['nullable', 'date'],
            'estatus' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'is_disfrutadas' => ['nullable'],
        ]);

        $data['estatus'] = strtoupper(trim($data['estatus']));
        $data['is_disfrutadas'] = $request->boolean('is_disfrutadas') ? 1 : 0;

        // Si ya reintegró, forzar disfrutadas
        if (! empty($data['fecha_reintegro']) && Carbon::parse($data['fecha_reintegro'])->lte(Carbon::today())) {
            $data['is_disfrutadas'] = 1;
        }

        return $data;
    }

    private function esVencida(OficialesVacacione $v): bool
    {
        return strtoupper((string) $v->estatus) === 'VENCIDAS';
    }

    private function esEnProceso(OficialesVacacione $v): bool
    {
        if ((int) $v->is_disfrutadas === 1) {
            return false;
        }

        $estatus = strtoupper((string) $v->estatus);

        return ! in_array($estatus, ['VENCIDAS', 'NEGADAS'], true);
    }
}
