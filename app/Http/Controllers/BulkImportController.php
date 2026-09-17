<?php

namespace App\Http\Controllers;

use App\Support\BulkImport\BulkImportRegistry;
use App\Support\BulkImport\BulkImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BulkImportController extends Controller
{
    public function __construct(private BulkImportService $service) {}

    public function template(string $module): StreamedResponse
    {
        if (! in_array($module, BulkImportRegistry::keys(), true)) {
            abort(404, 'Módulo no encontrado');
        }

        return $this->service->downloadTemplate($module);
    }

    public function import(Request $request): JsonResponse
    {
        $moduleKey = (string) $request->input('module', '');
        $module = BulkImportRegistry::get($moduleKey);

        if (! $module) {
            return response()->json([
                'ok' => false,
                'msj' => 'Módulo no válido.',
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'failed' => 0,
                'errors' => [],
            ], 422);
        }

        $format = $module['format'] ?? 'excel';

        if ($format === 'images') {
            $request->validate([
                'module' => 'required|string|in:'.implode(',', BulkImportRegistry::keys()),
                'files' => 'required|array|min:1|max:100',
                'files.*' => 'required|file|image|max:5120',
            ], [
                'module.required' => 'Seleccione un módulo.',
                'files.required' => 'Seleccione al menos una fotografía.',
                'files.min' => 'Seleccione al menos una fotografía.',
                'files.max' => 'Puede subir máximo 100 fotografías a la vez.',
                'files.*.image' => 'Solo se permiten imágenes (JPG, PNG, WEBP, GIF).',
                'files.*.max' => 'Cada fotografía no debe superar 5 MB.',
            ]);

            $result = $this->service->importFotografias($request->file('files', []));

            return response()->json($result, $result['ok'] ? 200 : 422);
        }

        $request->validate([
            'module' => 'required|string|in:'.implode(',', BulkImportRegistry::keys()),
            'file' => 'required|file|extensions:xlsx,xls,csv|max:10240',
        ], [
            'module.required' => 'Seleccione un módulo.',
            'module.in' => 'Módulo no válido.',
            'file.required' => 'Adjunte un archivo Excel.',
            'file.extensions' => 'El archivo debe ser Excel (.xlsx, .xls) o CSV.',
            'file.max' => 'El archivo no debe superar 10 MB.',
        ]);

        $result = $this->service->import($moduleKey, $request->file('file'));

        return response()->json($result, $result['ok'] ? 200 : 422);
    }
}
