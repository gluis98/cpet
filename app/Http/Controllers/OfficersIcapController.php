<?php

namespace App\Http\Controllers;

use App\Models\OficialesIcapExpediente;
use App\Models\OficialesIcapSobreviviente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficersIcapController extends Controller
{
    public function indexExpedientes($id)
    {
        return response()->json(
            OficialesIcapExpediente::where('id_policia', $id)
                ->orderByDesc('id')
                ->get(),
            200
        );
    }

    public function storeExpediente(Request $request)
    {
        $data = $this->validatedExpediente($request, true);
        OficialesIcapExpediente::create($data);

        return response()->json(['msj' => 'Expediente registrado con éxito.'], 201);
    }

    public function showExpediente($id)
    {
        return response()->json(OficialesIcapExpediente::findOrFail($id), 200);
    }

    public function updateExpediente(Request $request, $id)
    {
        $record = OficialesIcapExpediente::findOrFail($id);
        $record->update($this->validatedExpediente($request, false));

        return response()->json(['msj' => 'Expediente actualizado con éxito.'], 200);
    }

    public function destroyExpediente($id)
    {
        OficialesIcapExpediente::destroy($id);

        return response()->json(['msj' => 'Expediente eliminado con éxito.'], 200);
    }

    public function indexSobreviviente($id)
    {
        return response()->json(
            OficialesIcapSobreviviente::where('id_policia', $id)
                ->orderByDesc('id')
                ->get()
                ->map(fn ($row) => $this->withCopiaUrl($row)),
            200
        );
    }

    public function storeSobreviviente(Request $request)
    {
        $data = $this->validatedSobreviviente($request, true);
        $data = $this->storeCopia($request, $data);

        OficialesIcapSobreviviente::create($data);

        return response()->json(['msj' => 'Registro de sobreviviente guardado con éxito.'], 201);
    }

    public function showSobreviviente($id)
    {
        return response()->json(
            $this->withCopiaUrl(OficialesIcapSobreviviente::findOrFail($id)),
            200
        );
    }

    public function updateSobreviviente(Request $request, $id)
    {
        $record = OficialesIcapSobreviviente::findOrFail($id);
        $data = $this->validatedSobreviviente($request, false);
        $data = $this->storeCopia($request, $data, $record);

        $record->update($data);

        return response()->json(['msj' => 'Registro de sobreviviente actualizado con éxito.'], 200);
    }

    public function destroySobreviviente($id)
    {
        $record = OficialesIcapSobreviviente::findOrFail($id);
        $this->deleteCopia($record->copia_digitalizada);
        $record->delete();

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function validatedExpediente(Request $request, bool $creating): array
    {
        $rules = [
            'causa' => ['nullable', 'string'],
            'resulta' => ['nullable', 'string'],
            'culminacion_proceso' => ['nullable', 'string'],
        ];

        if ($creating) {
            $rules['id_policia'] = ['required', 'integer'];
        }

        return $request->validate($rules);
    }

    private function validatedSobreviviente(Request $request, bool $creating): array
    {
        $rules = [
            'observaciones' => ['nullable', 'string'],
            'resulta' => ['nullable', 'string'],
            'culminacion_proceso' => ['nullable', 'string'],
            'copia_digitalizada' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];

        if ($creating) {
            $rules['id_policia'] = ['required', 'integer'];
        }

        $data = $request->validate($rules);
        unset($data['copia_digitalizada']);

        return $data;
    }

    private function storeCopia(Request $request, array $data, ?OficialesIcapSobreviviente $existing = null): array
    {
        if (! $request->hasFile('copia_digitalizada')) {
            return $data;
        }

        $policiaId = (int) ($data['id_policia'] ?? $existing?->id_policia);
        $folderPath = 'icap/'.$policiaId.'/sobreviviente';

        if (! Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath, 0755, true);
        }

        if ($existing?->copia_digitalizada) {
            $this->deleteCopia($existing->copia_digitalizada);
        }

        $data['copia_digitalizada'] = $request->file('copia_digitalizada')->store($folderPath, 'public');

        return $data;
    }

    private function deleteCopia(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function withCopiaUrl(OficialesIcapSobreviviente $record): OficialesIcapSobreviviente
    {
        if ($record->copia_digitalizada) {
            $record->copia_digitalizada_url = Storage::disk('public')->url($record->copia_digitalizada);
        }

        return $record;
    }
}
