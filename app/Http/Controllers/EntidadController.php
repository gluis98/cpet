<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    /**
     * Obtener (o crear) el registro único de entidad.
     */
    public function show()
    {
        return response()->json($this->current(), 200);
    }

    /**
     * Guardar comandante general y director de RRHH.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'director_general' => ['nullable', 'string', 'max:255'],
            'rrhh' => ['nullable', 'string', 'max:255'],
        ]);

        $entidad = $this->current();
        $entidad->fill([
            'director_general' => filled($data['director_general'] ?? null)
                ? trim((string) $data['director_general'])
                : null,
            'rrhh' => filled($data['rrhh'] ?? null)
                ? trim((string) $data['rrhh'])
                : null,
        ]);
        $entidad->save();

        return response()->json([
            'msj' => 'Datos de la entidad guardados con éxito.',
            'entidad' => $entidad,
        ], 200);
    }

    private function current(): Entidad
    {
        $entidad = Entidad::query()->first();
        if (! $entidad) {
            $entidad = Entidad::create([
                'director_general' => null,
                'rrhh' => null,
            ]);
        }

        return $entidad;
    }
}
