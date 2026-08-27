<?php

namespace App\Http\Controllers;

use App\Models\OficialesUrra;
use App\Support\UrraEstatusSync;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfficersUrraController extends Controller
{
    public function index($id)
    {
        UrraEstatusSync::sincronizarVencidos((int) $id);

        $rows = OficialesUrra::where('id_policia', $id)
            ->orderByDesc('fecha_inicio')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => $rows,
            'counts' => [
                'total' => $rows->count(),
                'en_servicio' => $rows->where('en_servicio', true)->count(),
                'finalizados' => $rows->where('en_servicio', false)->count(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $this->payload($request);
        $record = OficialesUrra::create($data);

        UrraEstatusSync::actualizarEstatusFuncionario((int) $record->id_policia);

        return response()->json(['msj' => 'Registro URRA guardado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(OficialesUrra::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $record = OficialesUrra::findOrFail($id);
        $record->update($this->payload($request, $record));

        UrraEstatusSync::actualizarEstatusFuncionario((int) $record->id_policia);

        return response()->json(['msj' => 'Registro URRA actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        $record = OficialesUrra::findOrFail($id);
        $idPolicia = (int) $record->id_policia;
        $record->delete();

        UrraEstatusSync::actualizarEstatusFuncionario($idPolicia);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function payload(Request $request, ?OficialesUrra $existing = null): array
    {
        $data = $request->validate([
            'id_policia' => [$existing ? 'sometimes' : 'required', 'integer'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_culminacion' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'tiempo_servicio' => ['nullable', 'string', 'max:120'],
            'en_servicio' => ['nullable'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $inicio = $data['fecha_inicio'];
        $fin = $data['fecha_culminacion'] ?? null;
        $hoy = Carbon::today();

        // Si la culminación es posterior a hoy → en servicio automáticamente
        if ($fin && Carbon::parse($fin)->gt($hoy)) {
            $data['en_servicio'] = true;
        } elseif ($fin && Carbon::parse($fin)->lte($hoy)) {
            $data['en_servicio'] = false;
        } else {
            $data['en_servicio'] = $request->boolean('en_servicio');
        }

        $data['tiempo_servicio'] = trim((string) ($data['tiempo_servicio'] ?? '')) !== ''
            ? trim($data['tiempo_servicio'])
            : OficialesUrra::calcularTiempoServicio($inicio, $fin);

        return $data;
    }
}
