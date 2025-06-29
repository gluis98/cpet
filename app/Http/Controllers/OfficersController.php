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
     */
    public function index() {
        return response()->json(Oficiale::with('oficiales_cargos', 'oficiales_cargos.cargo')->get(), 200);
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

        return response()->json(['msj' => "Registro realizado con éxito."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(Oficiale::with('oficiales_cargos', 'oficiales_cargos.cargo')->findOrFail($id), 200);
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
