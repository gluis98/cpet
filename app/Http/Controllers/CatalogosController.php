<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargosAdministrativo;
use App\Models\CatalogoCurso;
use App\Models\Discapacidade;
use Illuminate\Http\Request;

class CatalogosController extends Controller
{
    /* ---------- Discapacidades ---------- */

    public function discapacidadesIndex()
    {
        return response()->json(
            Discapacidade::orderBy('nombre')->get(['id', 'nombre']),
            200
        );
    }

    public function discapacidadesStore(Request $request)
    {
        $nombre = $this->nombreFromRequest($request);
        $item = Discapacidade::firstOrCreate(['nombre' => $nombre], ['nombre' => $nombre]);

        return response()->json([
            'msj' => 'Discapacidad registrada.',
            'discapacidad' => $item,
            'item' => $this->catalogItem($item->id, $item->nombre),
        ], 201);
    }

    public function discapacidadesShow($id)
    {
        $item = Discapacidade::findOrFail($id);

        return response()->json($this->catalogItem($item->id, $item->nombre), 200);
    }

    public function discapacidadesUpdate(Request $request, $id)
    {
        $item = Discapacidade::findOrFail($id);
        $nombre = $this->nombreFromRequest($request, 'discapacidades', 'nombre', $item->id);
        $item->update(['nombre' => $nombre]);

        return response()->json([
            'msj' => 'Discapacidad actualizada.',
            'item' => $this->catalogItem($item->id, $item->nombre),
        ], 200);
    }

    public function discapacidadesDestroy($id)
    {
        $item = Discapacidade::findOrFail($id);

        if ($item->familiares()->exists()) {
            return response()->json([
                'msj' => 'No se puede eliminar: hay familiares asociados a esta discapacidad.',
            ], 422);
        }

        $item->delete();

        return response()->json(['msj' => 'Discapacidad eliminada.'], 200);
    }

    /* ---------- Catálogo de cursos ---------- */

    public function cursosIndex()
    {
        return response()->json(
            CatalogoCurso::orderBy('nombre')->get(['id', 'nombre']),
            200
        );
    }

    public function cursosStore(Request $request)
    {
        $nombre = $this->nombreFromRequest($request);
        $item = CatalogoCurso::firstOrCreate(['nombre' => $nombre], ['nombre' => $nombre]);

        return response()->json([
            'msj' => 'Curso/diplomado registrado.',
            'curso' => $item,
            'item' => $this->catalogItem($item->id, $item->nombre),
        ], 201);
    }

    public function cursosShow($id)
    {
        $item = CatalogoCurso::findOrFail($id);

        return response()->json($this->catalogItem($item->id, $item->nombre), 200);
    }

    public function cursosUpdate(Request $request, $id)
    {
        $item = CatalogoCurso::findOrFail($id);
        $nombre = $this->nombreFromRequest($request, 'catalogo_cursos', 'nombre', $item->id);
        $item->update(['nombre' => $nombre]);
        $item->oficiales_cursos()->update(['nombre' => $nombre]);

        return response()->json([
            'msj' => 'Curso/diplomado actualizado.',
            'item' => $this->catalogItem($item->id, $item->nombre),
        ], 200);
    }

    public function cursosDestroy($id)
    {
        $item = CatalogoCurso::findOrFail($id);

        if ($item->oficiales_cursos()->exists()) {
            return response()->json([
                'msj' => 'No se puede eliminar: hay cursos de funcionarios asociados a este nombre.',
            ], 422);
        }

        $item->delete();

        return response()->json(['msj' => 'Curso/diplomado eliminado.'], 200);
    }

    /* ---------- Cargos (jerarquías) ---------- */

    public function cargosIndex()
    {
        return response()->json(
            Cargo::orderBy('nombre_cargo')
                ->get(['id', 'nombre_cargo'])
                ->map(fn ($c) => $this->catalogItem($c->id, $c->nombre_cargo)),
            200
        );
    }

    public function cargosStore(Request $request)
    {
        $nombre = $this->nombreFromRequest($request, null, null, null, ['nombre', 'nombre_cargo']);
        $item = Cargo::firstOrCreate(['nombre_cargo' => $nombre], ['nombre_cargo' => $nombre]);

        return response()->json([
            'msj' => 'Cargo registrado.',
            'cargo' => $item,
            'item' => $this->catalogItem($item->id, $item->nombre_cargo),
        ], 201);
    }

    public function cargosShow($id)
    {
        $item = Cargo::findOrFail($id);

        return response()->json($this->catalogItem($item->id, $item->nombre_cargo), 200);
    }

    public function cargosUpdate(Request $request, $id)
    {
        $item = Cargo::findOrFail($id);
        $nombre = $this->nombreFromRequest($request, 'cargos', 'nombre_cargo', $item->id, ['nombre', 'nombre_cargo']);
        $item->update(['nombre_cargo' => $nombre]);

        return response()->json([
            'msj' => 'Cargo actualizado.',
            'item' => $this->catalogItem($item->id, $item->nombre_cargo),
        ], 200);
    }

    public function cargosDestroy($id)
    {
        $item = Cargo::findOrFail($id);

        if ($item->oficiales()->exists()) {
            return response()->json([
                'msj' => 'No se puede eliminar: hay funcionarios con este cargo en jerarquías.',
            ], 422);
        }

        $item->delete();

        return response()->json(['msj' => 'Cargo eliminado.'], 200);
    }

    /* ---------- Cargos administrativos ---------- */

    public function cargosAdministrativosIndex()
    {
        return response()->json(
            CargosAdministrativo::orderBy('nombre_cargo')
                ->get(['id', 'nombre_cargo'])
                ->map(fn ($c) => $this->catalogItem($c->id, $c->nombre_cargo)),
            200
        );
    }

    public function cargosAdministrativosStore(Request $request)
    {
        $nombre = $this->nombreFromRequest($request, null, null, null, ['nombre', 'nombre_cargo']);
        $item = CargosAdministrativo::firstOrCreate(['nombre_cargo' => $nombre], ['nombre_cargo' => $nombre]);

        return response()->json([
            'msj' => 'Cargo administrativo registrado.',
            'cargo' => $item,
            'item' => $this->catalogItem($item->id, $item->nombre_cargo),
        ], 201);
    }

    public function cargosAdministrativosShow($id)
    {
        $item = CargosAdministrativo::findOrFail($id);

        return response()->json($this->catalogItem($item->id, $item->nombre_cargo), 200);
    }

    public function cargosAdministrativosUpdate(Request $request, $id)
    {
        $item = CargosAdministrativo::findOrFail($id);
        $nombre = $this->nombreFromRequest($request, 'cargos_administrativos', 'nombre_cargo', $item->id, ['nombre', 'nombre_cargo']);
        $item->update(['nombre_cargo' => $nombre]);

        return response()->json([
            'msj' => 'Cargo administrativo actualizado.',
            'item' => $this->catalogItem($item->id, $item->nombre_cargo),
        ], 200);
    }

    public function cargosAdministrativosDestroy($id)
    {
        $item = CargosAdministrativo::findOrFail($id);

        if ($item->oficiales()->exists()) {
            return response()->json([
                'msj' => 'No se puede eliminar: hay funcionarios asociados a este cargo administrativo.',
            ], 422);
        }

        $item->delete();

        return response()->json(['msj' => 'Cargo administrativo eliminado.'], 200);
    }

    /* ---------- Municipios (Estado Trujillo) ---------- */

    public function municipiosIndex(Request $request)
    {
        $estadoId = (int) $request->input('estado_id', \App\Models\Municipio::ESTADO_TRUJILLO_ID);

        $items = \App\Models\Municipio::query()
            ->where('estado_id', $estadoId)
            ->orderBy('descripcion')
            ->get(['id', 'descripcion'])
            ->map(fn ($m) => $this->catalogItem($m->id, $m->descripcion));

        return response()->json($items, 200);
    }

    public function municipiosStore(Request $request)
    {
        $descripcion = $this->descripcionFromRequest($request);
        $estadoId = (int) $request->input('estado_id', \App\Models\Municipio::ESTADO_TRUJILLO_ID);

        $item = \App\Models\Municipio::firstOrCreate(
            ['descripcion' => $descripcion, 'estado_id' => $estadoId],
            ['descripcion' => $descripcion, 'estado_id' => $estadoId]
        );

        return response()->json([
            'msj' => 'Municipio registrado.',
            'municipio' => $item,
            'item' => $this->catalogItem($item->id, $item->descripcion),
        ], 201);
    }

    /* ---------- Parroquias ---------- */

    public function parroquiasIndex(Request $request)
    {
        $municipioId = (int) $request->input('municipio_id', 0);
        if ($municipioId <= 0) {
            return response()->json([], 200);
        }

        $items = \App\Models\Parroquia::query()
            ->where('municipio_id', $municipioId)
            ->orderBy('descripcion')
            ->get(['id', 'descripcion'])
            ->map(fn ($p) => $this->catalogItem($p->id, $p->descripcion));

        return response()->json($items, 200);
    }

    public function parroquiasStore(Request $request)
    {
        $descripcion = $this->descripcionFromRequest($request);
        $municipioId = (int) $request->input('municipio_id', 0);

        if ($municipioId <= 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'municipio_id' => 'Seleccione un municipio antes de agregar la parroquia.',
            ]);
        }

        $item = \App\Models\Parroquia::firstOrCreate(
            ['descripcion' => $descripcion, 'municipio_id' => $municipioId],
            [
                'descripcion' => $descripcion,
                'municipio_id' => $municipioId,
                'atencionfamilias' => 0,
            ]
        );

        return response()->json([
            'msj' => 'Parroquia registrada.',
            'parroquia' => $item,
            'item' => $this->catalogItem($item->id, $item->descripcion),
        ], 201);
    }

    /* ---------- Centros de votación ---------- */

    public function centrosVotacionIndex(Request $request)
    {
        $parroquiaId = (int) $request->input('parroquia_id', 0);
        $municipioId = (int) $request->input('municipio_id', 0);

        $query = \App\Models\CentroVotacion::query()->orderBy('nombre');

        if ($parroquiaId > 0) {
            $query->where('parroquia_id', $parroquiaId);
        } elseif ($municipioId > 0) {
            $query->where('municipio_id', $municipioId);
        } else {
            return response()->json([], 200);
        }

        $items = $query->get(['id', 'nombre'])
            ->map(fn ($c) => $this->catalogItem($c->id, $c->nombre));

        return response()->json($items, 200);
    }

    public function centrosVotacionStore(Request $request)
    {
        $nombre = $this->descripcionFromRequest($request);
        $parroquiaId = (int) $request->input('parroquia_id', 0);
        $municipioId = (int) $request->input('municipio_id', 0);

        if ($parroquiaId <= 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'parroquia_id' => 'Seleccione una parroquia antes de agregar el centro de votación.',
            ]);
        }

        $parroquia = \App\Models\Parroquia::findOrFail($parroquiaId);
        if ($municipioId <= 0) {
            $municipioId = (int) $parroquia->municipio_id;
        }

        $item = \App\Models\CentroVotacion::firstOrCreate(
            ['nombre' => $nombre, 'parroquia_id' => $parroquiaId],
            [
                'nombre' => $nombre,
                'parroquia_id' => $parroquiaId,
                'municipio_id' => $municipioId,
            ]
        );

        return response()->json([
            'msj' => 'Centro de votación registrado.',
            'centro_votacion' => $item,
            'item' => $this->catalogItem($item->id, $item->nombre),
        ], 201);
    }

    private function catalogItem(int $id, string $nombre): array
    {
        return [
            'id' => $id,
            'nombre' => $nombre,
        ];
    }

    /**
     * Acepta "nombre" o "nombre_cargo" desde el formulario / SweetAlert.
     */
    private function nombreFromRequest(
        Request $request,
        ?string $uniqueTable = null,
        ?string $uniqueColumn = null,
        ?int $ignoreId = null,
        array $keys = ['nombre']
    ): string {
        $nombre = '';
        foreach ($keys as $key) {
            $candidate = trim((string) $request->input($key, ''));
            if ($candidate !== '') {
                $nombre = $candidate;
                break;
            }
        }

        if ($nombre === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $keys[0] => 'El nombre es obligatorio.',
            ]);
        }

        if (strlen($nombre) > 255) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $keys[0] => 'El nombre no puede superar 255 caracteres.',
            ]);
        }

        if ($uniqueTable && $uniqueColumn) {
            $query = \Illuminate\Support\Facades\DB::table($uniqueTable)->where($uniqueColumn, $nombre);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if ($query->exists()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    $keys[0] => 'Este nombre ya está registrado.',
                ]);
            }
        }

        return $nombre;
    }

    private function descripcionFromRequest(Request $request, array $keys = ['descripcion', 'nombre']): string
    {
        $descripcion = '';
        foreach ($keys as $key) {
            $candidate = trim((string) $request->input($key, ''));
            if ($candidate !== '') {
                $descripcion = $candidate;
                break;
            }
        }

        if ($descripcion === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $keys[0] => 'La descripción es obligatoria.',
            ]);
        }

        if (strlen($descripcion) > 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $keys[0] => 'La descripción no puede superar 100 caracteres.',
            ]);
        }

        return $descripcion;
    }
}
