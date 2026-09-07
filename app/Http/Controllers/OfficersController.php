<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class OfficersController extends Controller
{
    /**
     * Listado rápido para la tabla de funcionarios (sin DataTables).
     */
    public function index(Request $request)
    {
        try {
            $page = max(1, (int) $request->get('page', 1));
            $perPage = (int) $request->get('per_page', 25);
            if (! in_array($perPage, [10, 25, 50, 100], true)) {
                $perPage = 25;
            }
            $search = trim((string) $request->get('q', $request->get('search', '')));
            $hasTipoRetiro = Schema::hasColumn('oficiales', 'tipo_retiro');

            $base = Oficiale::query();
            if ($request->filled('tipo_funcionario')) {
                $base->where('tipo_funcionario', Oficiale::normalizeTipo($request->get('tipo_funcionario')));
            }
            if ($request->filled('estatus')) {
                $base->where('estatus', $request->get('estatus'));
            }

            if ($search !== '') {
                $like = '%'.$search.'%';
                $base->where(function ($q) use ($like) {
                    $q->where('numero_placa', 'like', $like)
                        ->orWhere('documento_identidad', 'like', $like)
                        ->orWhere('nombre_completo', 'like', $like)
                        ->orWhere('telefono', 'like', $like)
                        ->orWhere('estatus', 'like', $like)
                        ->orWhereHas('cargos_administrativo', function ($cq) use ($like) {
                            $cq->where('nombre_cargo', 'like', $like);
                        })
                        ->orWhereHas('oficiales_cargos', function ($cq) use ($like) {
                            $cq->where('is_actual', 1)
                                ->whereHas('cargo', function ($c) use ($like) {
                                    $c->where('nombre_cargo', 'like', $like);
                                });
                        });
                });
            }

            $total = (clone $base)->count();

            $select = [
                'id',
                'numero_placa',
                'documento_identidad',
                'nombre_completo',
                'telefono',
                'fecha_ingreso',
                'estatus',
                'cargo_administrativo_id',
                'tipo_funcionario',
            ];
            if ($hasTipoRetiro) {
                $select[] = 'tipo_retiro';
            }

            $rows = (clone $base)
                ->select($select)
                ->with([
                    'cargos_administrativo:id,nombre_cargo',
                    'oficiales_cargos' => function ($q) {
                        $q->select('id', 'id_policia', 'id_cargo', 'is_actual')
                            ->where('is_actual', 1)
                            ->with('cargo:id,nombre_cargo')
                            ->orderByDesc('id')
                            ->limit(1);
                    },
                ])
                ->orderBy('nombre_completo')
                ->forPage($page, $perPage)
                ->get()
                ->map(function ($row) use ($hasTipoRetiro) {
                    $jerarquia = optional(optional($row->oficiales_cargos->first())->cargo)->nombre_cargo;

                    return [
                        'id' => (int) $row->id,
                        'numero_placa' => $row->numero_placa,
                        'documento_identidad' => $row->documento_identidad,
                        'nombre_completo' => $row->nombre_completo,
                        'telefono' => $row->telefono,
                        'fecha_ingreso' => $row->fecha_ingreso
                            ? substr((string) $row->fecha_ingreso, 0, 10)
                            : null,
                        'estatus' => $row->estatus,
                        'tipo_retiro' => $hasTipoRetiro ? ($row->tipo_retiro ?? null) : null,
                        'jerarquia' => $jerarquia,
                        'cargo' => optional($row->cargos_administrativo)->nombre_cargo,
                    ];
                })
                ->values();

            return response()->json([
                'data' => $rows,
                'meta' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'last_page' => max(1, (int) ceil($total / max(1, $perPage))),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Error listando funcionarios', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'data' => [],
                'meta' => [
                    'page' => 1,
                    'per_page' => 25,
                    'total' => 0,
                    'last_page' => 1,
                ],
                'error' => 'No se pudo cargar el listado de funcionarios.',
                'detail' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $oficiales = Oficiale::create($request->all());

        if ($request->hasFile('fotografia') && $request->file('fotografia')->isValid()) {
            $file = $request->file('fotografia');

            if (empty($oficiales->id)) {
                Log::error('El ID del modelo Oficiale es nulo o inválido', ['id' => $oficiales->id]);

                return response()->json(['error' => 'El ID del registro no es válido.'], 400);
            }

            $folderPath = 'fotografias/'.$oficiales->id;

            if (! Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath, 0775, true);
            }

            $oldFoto = $oficiales->fotografia;

            try {
                $filePath = $file->store($folderPath, 'public');
            } catch (\Exception $e) {
                Log::error('Error al almacenar el archivo', ['error' => $e->getMessage(), 'folderPath' => $folderPath]);

                return response()->json(['error' => 'No se pudo almacenar el archivo: '.$e->getMessage()], 500);
            }

            $oficiales->fotografia = $filePath;
            $oficiales->save();

            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
        }

        return response()->json(['msj' => 'Registro realizado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(Oficiale::with('oficiales_cargos', 'oficiales_cargos.cargo', 'cargos_administrativo')->findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $oficiales = Oficiale::findOrFail($id);
        $oficiales->update($request->all());
        if ($request->hasFile('fotografia') && $request->file('fotografia')->isValid()) {
            $file = $request->file('fotografia');

            if (empty($oficiales->id)) {
                Log::error('El ID del modelo Oficiale es nulo o inválido', ['id' => $id]);

                return response()->json(['error' => 'El ID del registro no es válido.'], 400);
            }

            $folderPath = 'fotografias/'.$oficiales->id;

            if (! Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath, 0775, true);
            }

            $oldFoto = $oficiales->fotografia;

            try {
                $filePath = $file->store($folderPath, 'public');
            } catch (\Exception $e) {
                Log::error('Error al almacenar el archivo', ['error' => $e->getMessage(), 'folderPath' => $folderPath]);

                return response()->json(['error' => 'No se pudo almacenar el archivo: '.$e->getMessage()], 500);
            }

            $oficiales->fotografia = $filePath;
            $oficiales->save();

            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
        }

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        Oficiale::destroy($id);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }
}
