<?php

namespace App\Http\Controllers;

use App\Models\OficialesAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficersAcademyController extends Controller
{
    public function index($id)
    {
        return response()->json(
            OficialesAcademico::where('id_policia', $id)
                ->orderByRaw('fecha_fin IS NULL')
                ->orderByDesc('fecha_fin')
                ->orderByDesc('id')
                ->get()
                ->map(fn ($row) => $this->withDocumentUrl($row)),
            200
        );
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data = $this->storeDocument($request, $data);

        $record = OficialesAcademico::create($data);

        return response()->json([
            'msj' => 'Registro realizado con éxito.',
            'data' => $this->withDocumentUrl($record),
        ], 201);
    }

    public function show($id)
    {
        return response()->json(
            $this->withDocumentUrl(OficialesAcademico::findOrFail($id)),
            200
        );
    }

    public function update(Request $request, $id)
    {
        $record = OficialesAcademico::findOrFail($id);
        $data = $this->validated($request, false);
        $data = $this->storeDocument($request, $data, $record);

        $record->update($data);

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        $record = OficialesAcademico::findOrFail($id);
        $this->deleteDocument($record->documento_fondo_negro);
        $record->delete();

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function validated(Request $request, bool $creating): array
    {
        $rules = [
            'tipo_formacion' => ['required', 'string', 'max:255'],
            'titulo' => ['nullable', 'string', 'max:255'],
            'institucion' => ['nullable', 'string', 'max:255'],
            'anio_graduacion' => ['required', 'integer', 'min:1950', 'max:2100'],
            'descripcion' => ['nullable', 'string'],
            'documento_fondo_negro' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];

        if ($creating) {
            $rules['id_policia'] = ['required', 'integer'];
        }

        $data = $request->validate($rules);

        $year = (int) $data['anio_graduacion'];
        unset($data['anio_graduacion'], $data['documento_fondo_negro']);

        $data['fecha_fin'] = sprintf('%04d-12-31', $year);
        $data['fecha_inicio'] = null;

        return $data;
    }

    private function storeDocument(Request $request, array $data, ?OficialesAcademico $existing = null): array
    {
        if (! $request->hasFile('documento_fondo_negro')) {
            return $data;
        }

        $file = $request->file('documento_fondo_negro');
        $policiaId = (int) ($data['id_policia'] ?? $existing?->id_policia);
        $folderPath = 'academico/'.$policiaId;

        if (! Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath, 0755, true);
        }

        if ($existing?->documento_fondo_negro) {
            $this->deleteDocument($existing->documento_fondo_negro);
        }

        $data['documento_fondo_negro'] = $file->store($folderPath, 'public');

        return $data;
    }

    private function deleteDocument(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function withDocumentUrl(OficialesAcademico $record): OficialesAcademico
    {
        if ($record->documento_fondo_negro) {
            $record->documento_fondo_negro_url = Storage::disk('public')->url($record->documento_fondo_negro);
        }

        return $record;
    }
}
