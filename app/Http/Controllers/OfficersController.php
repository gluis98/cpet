<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OfficersController extends Controller
{
    /**
     * Display a listing of the resource.
     * Optimizado para DataTables server-side processing
     */
    public function index(Request $request) {
        // Si no es una petición DataTables, retornar todos los datos (para compatibilidad)
        if (!$request->has('draw')) {
            return response()->json(
                Oficiale::select('id', 'numero_placa', 'documento_identidad', 'nombre_completo', 
                                'telefono', 'fecha_ingreso', 'estatus', 'cargo_administrativo_id')
                    ->with([
                        'oficiales_cargos' => function($query) {
                            $query->select('id', 'id_policia', 'id_cargo', 'is_actual')
                                  ->where('is_actual', 1);
                        },
                        'oficiales_cargos.cargo:id,nombre_cargo',
                        'cargos_administrativo:id,nombre_cargo'
                    ])
                    ->get(), 
                200
            );
        }

        // Server-side processing para DataTables
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'] ?? '';
        $orderColumn = $request->get('order')[0]['column'] ?? 0;
        $orderDir = $request->get('order')[0]['dir'] ?? 'asc';

        $columns = [
            'numero_placa',
            'documento_identidad', 
            'nombre_completo',
            'telefono',
            'fecha_ingreso',
            'id', // jerarquía (relación)
            'cargo_administrativo_id', // cargo (relación)
            'estatus'
        ];

        $query = Oficiale::select(
            'id', 'numero_placa', 'documento_identidad', 'nombre_completo',
            'telefono', 'fecha_ingreso', 'estatus', 'cargo_administrativo_id'
        )->with([
            'oficiales_cargos' => function($q) {
                $q->select('id', 'id_policia', 'id_cargo', 'is_actual')
                  ->where('is_actual', 1)
                  ->with('cargo:id,nombre_cargo');
            },
            'cargos_administrativo:id,nombre_cargo'
        ]);

        // Búsqueda global
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('documento_identidad', 'like', "%{$search}%")
                  ->orWhere('numero_placa', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('estatus', 'like', "%{$search}%");
            });
        }

        $totalRecords = Oficiale::count();
        $filteredRecords = $query->count();

        // Ordenamiento
        if (isset($columns[$orderColumn]) && $orderColumn < 5) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        }

        // Paginación
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $oficiales = Oficiale::create($request->all());

        if($request->hasFile('fotografia') && $request->file('fotografia')->isValid()) {
            // Obtener el archivo
            $file = $request->file('fotografia');

            // Verificar que el ID sea válido
            if (empty($oficiales->id)) {
                Log::error('El ID del modelo Oficiale es nulo o inválido', ['id' => $oficiales->id]);
                return response()->json(['error' => 'El ID del registro no es válido.'], 400);
            }

            // Definir la ruta de destino
            $folderPath = 'fotografias/' . $oficiales->id;

            // Crear la carpeta si no existe
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath, 0775, true);
            }

            // Guardar la fotografía antigua para eliminarla después
            $oldFoto = $oficiales->fotografia;

            // Almacenar el archivo
            try {
                $filePath = $file->store($folderPath, 'public');
            } catch (\Exception $e) {
                Log::error('Error al almacenar el archivo', ['error' => $e->getMessage(), 'folderPath' => $folderPath]);
                return response()->json(['error' => 'No se pudo almacenar el archivo: ' . $e->getMessage()], 500);
            }

            // Actualizar el campo fotografia con la nueva ruta
            $oficiales->fotografia = $filePath;
            $oficiales->save();

            // Eliminar la fotografía antigua si existe
            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
        }

        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(Oficiale::with('oficiales_cargos', 'oficiales_cargos.cargo', 'cargos_administrativo')->findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = Oficiale::findOrFail($id);
        $oficiales->update($request->all());
        if($request->hasFile('fotografia') && $request->file('fotografia')->isValid()) {
            // Obtener el archivo
            $file = $request->file('fotografia');

            // Verificar que el ID sea válido
            if (empty($oficiales->id)) {
                Log::error('El ID del modelo Oficiale es nulo o inválido', ['id' => $id]);
                return response()->json(['error' => 'El ID del registro no es válido.'], 400);
            }

            // Definir la ruta de destino
            $folderPath = 'fotografias/' . $oficiales->id;

            // Crear la carpeta si no existe
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath, 0775, true);
            }

            // Guardar la fotografía antigua para eliminarla después
            $oldFoto = $oficiales->fotografia;

            // Almacenar el archivo
            try {
                $filePath = $file->store($folderPath, 'public');
            } catch (\Exception $e) {
                Log::error('Error al almacenar el archivo', ['error' => $e->getMessage(), 'folderPath' => $folderPath]);
                return response()->json(['error' => 'No se pudo almacenar el archivo: ' . $e->getMessage()], 500);
            }

            // Actualizar el campo fotografia con la nueva ruta
            $oficiales->fotografia = $filePath;
            $oficiales->save();

            // Eliminar la fotografía antigua si existe
            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
        }
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        Oficiale::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 204);
    }
}
