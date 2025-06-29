<?php

namespace App\Http\Controllers;

use App\Models\Oficiale;
use Illuminate\Http\Request;
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

        if($request->hasFile('fotografia')) {
            $file = $request->file('fotografia');
            $filePath = $file->store('fotografias/'.$oficiales->id, 'public'); // Carpeta "logos" en "storage/app/public"

            // Actualizar el campo "logo" con la ruta del archivo
            $oficiales->update(['fotografia' => $filePath]);
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
        if($request->hasFile('fotografia')) {
            $file = $request->file('fotografia');
            // Generar la ruta y almacenar el archivo
            $filePath = $file->store('fotografias/' . $oficiales->id, 'public');

            // Actualizar el campo fotografia con la ruta
            $oficiales->fotografia = $filePath;
            $oficiales->save();
            // Opcional: Eliminar la fotografía antigua si existe
            if ($oficiales->fotografia) {
                Storage::disk('public')->delete($oficiales->fotografia);
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
