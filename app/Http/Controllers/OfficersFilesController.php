<?php

namespace App\Http\Controllers;

use App\Models\OficialesDocumento;
use App\Models\OficialesSalud;
use App\Models\OficialesSaludReposo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                'archivo_url' => $filePath, // Ruta relativa para acceder desde el navegador
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

    public function get_reposos($id) {
        return response()->json(OficialesSaludReposo::findOrFail($id), 200);
    }

    public function updateReposo(Request $request, $id) {
        $oficiales = OficialesSalud::findOrFail($id);
        if($request->hasFile('reposos') && $request->file('reposos')->isValid()) {
            // Obtener el archivo
            $file = $request->file('reposos');

            // Verificar que el ID sea válido
            if (empty($oficiales->id)) {
                Log::error('El ID del modelo Oficiale es nulo o inválido', ['id' => $id]);
                return response()->json(['error' => 'El ID del registro no es válido.'], 400);
            }
            
            // Definir la ruta de destino
            $folderPath = 'reposos/' . $oficiales->id;

            // Crear la carpeta si no existe
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath, 0775, true);
            }

            foreach($file as $key){
                // Almacenar el archivo
                try {
                    $filePath = $file->store($folderPath, 'public');
                    $reposo = OficialesSaludReposo::create(['oficiales_salud_id' => $id, 'archivo' => $filePath]);
                } catch (\Exception $e) {
                    Log::error('Error al almacenar el archivo', ['error' => $e->getMessage(), 'folderPath' => $folderPath]);
                    return response()->json(['error' => 'No se pudo almacenar el archivo: ' . $e->getMessage()], 500);
                }
            }
        }
        return response()->json(['msj' => "Registro actualizado con éxito."], 200);
    }
}
