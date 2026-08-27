<?php

namespace App\Http\Controllers;

use App\Models\CatalogoCurso;
use App\Models\OficialesCurso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OfficersCoursesController extends Controller
{
    public function index($id)
    {
        return response()->json(
            OficialesCurso::with('catalogoCurso')
                ->where('id_policia', $id)
                ->orderByDesc('fecha_inicio')
                ->orderByDesc('id')
                ->get(),
            200
        );
    }

    public function store(Request $request)
    {
        OficialesCurso::create($this->validated($request, true));

        return response()->json(['msj' => 'Registro realizado con éxito.'], 201);
    }

    public function show($id)
    {
        return response()->json(
            OficialesCurso::with('catalogoCurso')->findOrFail($id),
            200
        );
    }

    public function update(Request $request, $id)
    {
        $curso = OficialesCurso::findOrFail($id);
        $curso->update($this->validated($request, false));

        return response()->json(['msj' => 'Registro actualizado con éxito.'], 200);
    }

    public function destroy($id)
    {
        OficialesCurso::destroy($id);

        return response()->json(['msj' => 'Registro eliminado con éxito.'], 200);
    }

    private function validated(Request $request, bool $creating): array
    {
        $rules = [
            'tipo' => ['required', 'string', 'max:100'],
            'catalogo_curso_id' => ['nullable', 'integer', 'exists:catalogo_cursos,id'],
            'nombre_nuevo' => ['nullable', 'string', 'max:255'],
            'institucion' => ['nullable', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'descripcion' => ['nullable', 'string'],
            'duracion_valor' => ['required', 'integer', 'min:1', 'max:9999'],
            'duracion_tipo' => ['required', Rule::in(['Años', 'Meses', 'Horas'])],
        ];

        if ($creating) {
            $rules['id_policia'] = ['required', 'integer'];
        }

        $data = $request->validate($rules);

        $nuevo = trim((string) ($data['nombre_nuevo'] ?? ''));
        unset($data['nombre_nuevo']);

        if ($nuevo !== '') {
            $catalogo = CatalogoCurso::firstOrCreate(['nombre' => $nuevo], ['nombre' => $nuevo]);
            $data['catalogo_curso_id'] = $catalogo->id;
        }

        if (empty($data['catalogo_curso_id'])) {
            throw ValidationException::withMessages([
                'catalogo_curso_id' => 'Seleccione o agregue el nombre del curso/diplomado.',
            ]);
        }

        $catalogo = CatalogoCurso::find($data['catalogo_curso_id']);
        $data['nombre'] = $catalogo?->nombre;

        return $data;
    }
}
