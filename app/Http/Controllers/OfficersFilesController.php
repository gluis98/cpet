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
    private const DEFAULT_TIPO_DOCUMENTO = 'Cedula de Identidad';

    /**
     * Listar documentos del funcionario.
     */
    public function index($id)
    {
        return response()->json(
            OficialesDocumento::where('id_policia', $id)->orderByDesc('id')->get(),
            200
        );
    }

    /**
     * Subir documento(s) del funcionario.
     */
    public function store(Request $request, $id)
    {
        if (! $request->hasFile('archivos')) {
            return response()->json(['error' => 'No se recibió ningún archivo.'], 422);
        }

        $uploaded = $request->file('archivos');
        $files = is_array($uploaded) ? $uploaded : [$uploaded];
        $created = [];

        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $filePath = $file->store('archivos/'.$id, 'public');
            $created[] = OficialesDocumento::create([
                'id_policia' => $id,
                'tipo_documento' => self::DEFAULT_TIPO_DOCUMENTO,
                'archivo_url' => $filePath,
                'fecha_subida' => now(),
            ]);
        }

        if ($created === []) {
            return response()->json(['error' => 'No se pudo procesar el archivo.'], 422);
        }

        return response()->json([
            'status' => 'ok',
            'data' => count($created) === 1 ? $created[0] : $created,
            'message' => 'Registro realizado con éxito',
        ], 200);
    }

    public function show($id)
    {
        return response()->json(OficialesDocumento::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $oficiales = OficialesDocumento::findOrFail($id);
        $oficiales->update($request->all());

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    /**
     * Eliminar documento del funcionario (registro + archivo físico).
     */
    public function destroy($id)
    {
        $doc = OficialesDocumento::findOrFail($id);
        $this->deleteStoredFile($doc->archivo_url);
        $doc->delete();

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    /**
     * Listar archivos de un reposo médico.
     */
    public function get_reposos($id)
    {
        return response()->json(
            OficialesSaludReposo::where('oficiales_salud_id', $id)->orderByDesc('id')->get(),
            200
        );
    }

    /**
     * Subir archivo(s) de reposo médico.
     */
    public function updateReposo(Request $request, $id)
    {
        OficialesSalud::findOrFail($id);

        $uploaded = $request->file('reposos') ?? $request->file('archivos');
        if (! $uploaded) {
            return response()->json(['error' => 'No se recibió ningún archivo.'], 422);
        }

        $files = is_array($uploaded) ? $uploaded : [$uploaded];
        $folderPath = 'reposos/'.$id;

        if (! Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath, 0775, true);
        }

        $created = 0;
        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            try {
                $filePath = $file->store($folderPath, 'public');
                OficialesSaludReposo::create([
                    'oficiales_salud_id' => $id,
                    'archivo' => $filePath,
                ]);
                $created++;
            } catch (\Exception $e) {
                Log::error('Error al almacenar archivo de reposo', [
                    'error' => $e->getMessage(),
                    'folderPath' => $folderPath,
                ]);

                return response()->json(['error' => 'No se pudo almacenar el archivo: '.$e->getMessage()], 500);
            }
        }

        if ($created === 0) {
            return response()->json(['error' => 'No se pudo procesar el archivo.'], 422);
        }

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    /**
     * Eliminar archivo de reposo (registro + archivo físico).
     */
    public function destroyReposo($id)
    {
        $reposo = OficialesSaludReposo::findOrFail($id);
        $this->deleteStoredFile($reposo->archivo);
        $reposo->delete();

        return response()->json(['msj' => 'Archivo eliminado con éxito.'], 200);
    }

    private function deleteStoredFile(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
