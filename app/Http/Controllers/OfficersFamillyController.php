<?php

namespace App\Http\Controllers;

use App\Models\Discapacidade;
use App\Models\OficialesFamiliare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class OfficersFamillyController extends Controller
{
    public function index($id)
    {
        return response()->json(
            OficialesFamiliare::with('discapacidade')
                ->where('id_policia', $id)
                ->orderBy('nombre_completo')
                ->get()
                ->map(fn ($row) => $this->withInformeUrl($row)),
            200
        );
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data = $this->storeInforme($request, $data);

        OficialesFamiliare::create($data);

        return response()->json(['msj' => 'Registro realizado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(
            $this->withInformeUrl(
                OficialesFamiliare::with('discapacidade')->findOrFail($id)
            ),
            200
        );
    }

    public function update(Request $request, $id)
    {
        $familiar = OficialesFamiliare::findOrFail($id);
        $data = $this->validated($request, false, $familiar);
        $data = $this->storeInforme($request, $data, $familiar);

        $familiar->update($data);

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        $familiar = OficialesFamiliare::findOrFail($id);
        $this->deleteInforme($familiar->informe_medico);
        $familiar->delete();

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function validated(Request $request, bool $creating, ?OficialesFamiliare $existing = null): array
    {
        $rules = [
            'nombre_completo' => ['required', 'string', 'max:255'],
            'parentesco' => ['required', 'string', 'max:100'],
            'fecha_nacimiento' => ['required', 'date'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'sexo' => ['required', 'in:M,F'],
            'edad' => ['nullable', 'integer', 'min:0', 'max:120'],
            'posee_discapacidad' => ['required', 'in:0,1,true,false,Si,No'],
            'discapacidad_id' => ['nullable', 'integer', 'exists:discapacidades,id'],
            'discapacidad_nueva' => ['nullable', 'string', 'max:255'],
            'discapacidad_requerimientos' => ['nullable', 'string'],
            'discapacidad_observaciones' => ['nullable', 'string'],
            'informe_medico' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];

        if ($creating) {
            $rules['id_policia'] = ['required', 'integer'];
        }

        $data = $request->validate($rules);

        $posee = in_array($data['posee_discapacidad'], [1, '1', true, 'true', 'Si'], true);
        $data['posee_discapacidad'] = $posee;

        unset($data['informe_medico']);

        if (! $posee) {
            if ($existing?->informe_medico) {
                $this->deleteInforme($existing->informe_medico);
                $data['informe_medico'] = null;
            }
            $data['discapacidad_id'] = null;
            $data['discapacidad_requerimientos'] = null;
            $data['discapacidad_observaciones'] = null;
            unset($data['discapacidad_nueva']);

            return $data;
        }

        $nueva = trim((string) ($data['discapacidad_nueva'] ?? ''));
        unset($data['discapacidad_nueva']);

        if ($nueva !== '') {
            $disc = Discapacidade::firstOrCreate(['nombre' => $nueva], ['nombre' => $nueva]);
            $data['discapacidad_id'] = $disc->id;
        }

        if (empty($data['discapacidad_id'])) {
            throw ValidationException::withMessages([
                'discapacidad_id' => 'Seleccione o agregue el tipo de discapacidad.',
            ]);
        }

        return $data;
    }

    private function storeInforme(Request $request, array $data, ?OficialesFamiliare $existing = null): array
    {
        if (! $request->hasFile('informe_medico')) {
            return $data;
        }

        $file = $request->file('informe_medico');
        $familiarId = $existing?->id;
        $policiaId = (int) ($data['id_policia'] ?? $existing?->id_policia);
        $folderPath = 'familiares/'.$policiaId.'/informes';

        if (! Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath, 0755, true);
        }

        if ($existing?->informe_medico) {
            $this->deleteInforme($existing->informe_medico);
        }

        $data['informe_medico'] = $file->store($folderPath, 'public');

        return $data;
    }

    private function deleteInforme(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function withInformeUrl(OficialesFamiliare $record): OficialesFamiliare
    {
        if ($record->informe_medico) {
            $record->informe_medico_url = Storage::disk('public')->url($record->informe_medico);
        }

        return $record;
    }
}
