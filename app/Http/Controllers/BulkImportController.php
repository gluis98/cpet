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
        $validated = $request->validate([
            'module' => 'required|string|in:'.implode(',', BulkImportRegistry::keys()),
            'file' => 'required|file|extensions:xlsx,xls,csv|max:10240',
        ], [
            'module.required' => 'Seleccione un módulo.',
            'module.in' => 'Módulo no válido.',
            'file.required' => 'Adjunte un archivo Excel.',
            'file.extensions' => 'El archivo debe ser Excel (.xlsx, .xls) o CSV.',
            'file.max' => 'El archivo no debe superar 10 MB.',
        ]);

        $result = $this->service->import($validated['module'], $request->file('file'));

        return response()->json($result, $result['ok'] ? 200 : 422);
    }
}
