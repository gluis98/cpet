<?php

namespace App\Http\Controllers;

use App\Models\Estacione;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StationController extends Controller
{
    public function index()
    {
        return response()->json(
            Estacione::query()
                ->orderBy('estacion')
                ->get(['id', 'estacion'])
                ->map(fn (Estacione $e) => [
                    'id' => $e->id,
                    'nombre' => $e->estacion,
                    'estacion' => $e->estacion,
                ]),
            200
        );
    }

    public function store(Request $request)
    {
        $nombre = trim((string) ($request->input('nombre') ?: $request->input('estacion') ?: ''));
        if ($nombre === '') {
            throw ValidationException::withMessages([
                'nombre' => 'El nombre de la estación es obligatorio.',
            ]);
        }

        $item = Estacione::query()
            ->get(['id', 'estacion'])
            ->first(function (Estacione $e) use ($nombre) {
                return mb_strtolower(trim((string) $e->estacion)) === mb_strtolower($nombre);
            });

        if (! $item) {
            $item = Estacione::create([
                'estacion' => $nombre,
                'descripcion' => $request->input('descripcion'),
            ]);
        }

        return response()->json([
            'msj' => 'Estación registrada.',
            'estacion' => $item,
            'item' => [
                'id' => $item->id,
                'nombre' => $item->estacion,
            ],
        ], 201);
    }

    public function show($id)
    {
        $item = Estacione::findOrFail($id);

        return response()->json([
            'id' => $item->id,
            'nombre' => $item->estacion,
            'estacion' => $item->estacion,
            'descripcion' => $item->descripcion,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $item = Estacione::findOrFail($id);
        $nombre = trim((string) ($request->input('nombre') ?: $request->input('estacion') ?: $item->estacion));
        $item->update([
            'estacion' => $nombre,
            'descripcion' => $request->input('descripcion', $item->descripcion),
        ]);

        return response()->json([
            'msj' => 'Estación actualizada.',
            'item' => [
                'id' => $item->id,
                'nombre' => $item->estacion,
            ],
        ], 200);
    }

    public function destroy($id)
    {
        Estacione::destroy($id);

        return response()->json(['msj' => 'Estación eliminada.'], 200);
    }
}
