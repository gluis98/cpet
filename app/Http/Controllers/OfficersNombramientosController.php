<?php

namespace App\Http\Controllers;

use App\Models\OficialesNombramiento;
use Illuminate\Http\Request;

class OfficersNombramientosController extends Controller
{
    public function index($id)
    {
        return response()->json(
            OficialesNombramiento::with(['estacione', 'tipo_nombramiento'])
                ->where('id_policia', $id)
                ->orderByDesc('is_actual')
                ->orderByRaw('fecha_inicio IS NULL')
                ->orderByDesc('fecha_inicio')
                ->orderByDesc('id')
                ->get(),
            200
        );
    }

    public function store(Request $request)
    {
        $data = $this->payload($request);
        $row = OficialesNombramiento::create($data);

        if ((int) $row->is_actual === 1) {
            OficialesNombramiento::query()
                ->where('id_policia', $row->id_policia)
                ->where('id', '!=', $row->id)
                ->update(['is_actual' => 0]);
        }

        return response()->json(['msj' => 'Registro realizado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(
            OficialesNombramiento::with(['estacione', 'tipo_nombramiento'])->findOrFail($id),
            200
        );
    }

    public function update(Request $request, $id)
    {
        $row = OficialesNombramiento::findOrFail($id);
        $row->update($this->payload($request, $row));

        if ((int) $row->is_actual === 1) {
            OficialesNombramiento::query()
                ->where('id_policia', $row->id_policia)
                ->where('id', '!=', $row->id)
                ->update(['is_actual' => 0]);
        }

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        OficialesNombramiento::destroy($id);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function payload(Request $request, ?OficialesNombramiento $existing = null): array
    {
        $data = $request->validate([
            'id_policia' => [$existing ? 'sometimes' : 'required', 'integer', 'exists:oficiales,id'],
            'id_estacion' => ['required', 'integer', 'exists:estaciones,id'],
            'id_tipo_nombramiento' => ['required', 'integer', 'exists:catalogo_nombramientos,id'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_final' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'is_actual' => ['nullable'],
        ]);

        $data['is_actual'] = $request->boolean('is_actual') ? 1 : 0;

        if (array_key_exists('descripcion', $data) && trim((string) $data['descripcion']) === '') {
            $data['descripcion'] = null;
        }

        if (empty($data['fecha_final'])) {
            $data['fecha_final'] = null;
        }

        return $data;
    }
}
