<?php

namespace App\Http\Controllers;

use App\Models\OficialesDocumento;
use Illuminate\Http\Request;

class OfficersFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id) {
        return response()->json(OficialesDocumento::where('id_policia', $id)->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id) {
        if ($request->hasFile('archivos')) {
            $file = $request->file('archivos');
            $filePath = $file->store('archivos/'.$id, 'public'); // Carpeta "logos" en "storage/app/public"

            // Actualizar el campo "logo" con la ruta del archivo
            $e = OficialesDocumento::create([
                'id_policia' => $id,
                'url_archivo' => $filePath, // Ruta relativa para acceder desde el navegador
                'fecha_subida' => \Carbon\Carbon::now()
            ]);
        }
        return response()->json([
           'status' => 'ok',
            'data' => $e,
            'message' => "Registro realizado con éxito"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        return response()->json(OficialesDocumento::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id) {
        $oficiales = OficialesDocumento::findOrFail($id);
        $oficiales->update($request->all());
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        OficialesDocumento::destroy($id);
        return response()->json(['msj' => "Registro eliminado con éxito."], 200);
    }
}
