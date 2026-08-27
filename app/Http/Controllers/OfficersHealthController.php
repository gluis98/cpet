<?php

namespace App\Http\Controllers;

use App\Models\OficialesSalud;
use App\Support\ReposoEstatusSync;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OfficersHealthController extends Controller
{
    public function index($id)
    {
        ReposoEstatusSync::sincronizarFinalizados((int) $id);

        return response()->json(
            OficialesSalud::where('id_policia', $id)->orderByDesc('id')->get(),
            200
        );
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $reposo = OficialesSalud::create($data);

        ReposoEstatusSync::actualizarEstatusFuncionario((int) $reposo->id_policia);

        return response()->json(['msj' => 'Registro realizado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(OficialesSalud::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $reposo = OficialesSalud::findOrFail($id);
        $data = $this->validated($request, false);
        $reposo->update($data);

        ReposoEstatusSync::actualizarEstatusFuncionario((int) $reposo->id_policia);

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        $reposo = OficialesSalud::findOrFail($id);
        $policiaId = (int) $reposo->id_policia;
        $reposo->delete();

        ReposoEstatusSync::actualizarEstatusFuncionario($policiaId);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function validated(Request $request, bool $creating): array
    {
        $rules = [
            'fecha_revision' => ['required', 'date'],
            'diagnostico' => ['required', 'string'],
            'fecha_reposo_inicio' => ['required', 'date'],
            'fecha_reposo_fin' => ['nullable', 'date', 'after_or_equal:fecha_reposo_inicio'],
            'dias_reposo' => ['nullable', 'integer', 'min:0'],
            'is_vigente' => ['required', Rule::in(['0', '1', '2', 0, 1, 2])],
        ];

        if ($creating) {
            $rules['id_policia'] = ['required', 'integer'];
        }

        $data = $request->validate($rules);
        $data['is_vigente'] = (int) $data['is_vigente'];

        if ($data['is_vigente'] === ReposoEstatusSync::VIGENTE_CONTINUO) {
            if (empty($data['fecha_reposo_fin'])) {
                $data['fecha_reposo_fin'] = null;
                $data['dias_reposo'] = null;
            }
        } elseif ($data['is_vigente'] === ReposoEstatusSync::VIGENTE_SI) {
            if (empty($data['fecha_reposo_fin'])) {
                throw ValidationException::withMessages([
                    'fecha_reposo_fin' => 'La fecha fin es obligatoria cuando el reposo está vigente.',
                ]);
            }
        }

        if (! empty($data['fecha_reposo_inicio']) && ! empty($data['fecha_reposo_fin'])) {
            $data['dias_reposo'] = $this->calcularDiasHabiles(
                $data['fecha_reposo_inicio'],
                $data['fecha_reposo_fin']
            );
        }

        if (
            $data['is_vigente'] === ReposoEstatusSync::VIGENTE_SI
            && ! empty($data['fecha_reposo_fin'])
            && Carbon::parse($data['fecha_reposo_fin'])->lte(Carbon::today())
        ) {
            $data['is_vigente'] = ReposoEstatusSync::VIGENTE_NO;
        }

        return $data;
    }

    private function calcularDiasHabiles(string $inicio, string $fin): int
    {
        $start = Carbon::parse($inicio)->startOfDay();
        $end = Carbon::parse($fin)->startOfDay();
        $businessDays = 0;

        while ($start->lte($end)) {
            if ($start->isWeekday()) {
                $businessDays++;
            }
            $start->addDay();
        }

        return $businessDays;
    }
}
