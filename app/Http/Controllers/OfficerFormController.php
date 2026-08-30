<?php

namespace App\Http\Controllers;

use App\Models\CargosAdministrativo;
use App\Models\Oficiale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OfficerFormController extends Controller
{
    public function index(string $tipo): View
    {
        $tipoFuncionario = Oficiale::normalizeTipo($tipo);
        $slug = array_search($tipoFuncionario, Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';

        $estatusCounts = Oficiale::query()
            ->where('tipo_funcionario', $tipoFuncionario)
            ->selectRaw('estatus, COUNT(*) as total')
            ->groupBy('estatus')
            ->pluck('total', 'estatus');

        return view('admin.officers.index', [
            'title' => 'Funcionarios — '.$tipoFuncionario,
            'tipo' => $slug,
            'tipoFuncionario' => $tipoFuncionario,
            'estatusList' => Oficiale::ESTATUS,
            'estatusCounts' => $estatusCounts,
            'totalFuncionarios' => $estatusCounts->sum(),
            'leftImagePath' => $this->logoDataUri(),
        ]);
    }

    public function create(string $tipo): View
    {
        $tipoFuncionario = Oficiale::normalizeTipo($tipo);
        $slug = array_search($tipoFuncionario, Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';

        return view('admin.officers.form', [
            'title' => 'Nuevo funcionario — '.$tipoFuncionario,
            'tipo' => $slug,
            'tipoFuncionario' => $tipoFuncionario,
            'oficial' => new Oficiale(['tipo_funcionario' => $tipoFuncionario]),
            'cargosAdministrativos' => CargosAdministrativo::orderBy('nombre_cargo')->get(),
            'leftImagePath' => $this->logoDataUri(),
        ]);
    }

    public function store(Request $request, string $tipo): RedirectResponse
    {
        $tipoFuncionario = Oficiale::normalizeTipo($tipo);
        $slug = array_search($tipoFuncionario, Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';
        $data = $this->validated($request);
        $data['tipo_funcionario'] = $tipoFuncionario;

        $oficial = Oficiale::create($data);
        $this->storePhoto($request, $oficial);

        return redirect()
            ->route('officers.tipo', $slug)
            ->with('success', 'Funcionario registrado con éxito.');
    }

    public function edit(string $tipo, int $id): View
    {
        $tipoFuncionario = Oficiale::normalizeTipo($tipo);
        $slug = array_search($tipoFuncionario, Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';
        $oficial = Oficiale::findOrFail($id);

        return view('admin.officers.form', [
            'title' => 'Editar funcionario — '.$oficial->nombre_completo,
            'tipo' => $slug,
            'tipoFuncionario' => $tipoFuncionario,
            'oficial' => $oficial,
            'cargosAdministrativos' => CargosAdministrativo::orderBy('nombre_cargo')->get(),
            'leftImagePath' => $this->logoDataUri(),
        ]);
    }

    public function update(Request $request, string $tipo, int $id): RedirectResponse
    {
        $tipoFuncionario = Oficiale::normalizeTipo($tipo);
        $slug = array_search($tipoFuncionario, Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';
        $oficial = Oficiale::findOrFail($id);
        $data = $this->validated($request);
        $data['tipo_funcionario'] = $tipoFuncionario;

        $oficial->update($data);
        $this->storePhoto($request, $oficial);

        return redirect()
            ->route('officers.form.edit', [$slug, $oficial->id])
            ->with('success', 'Funcionario actualizado con éxito.');
    }

    public function search(Request $request): View|RedirectResponse
    {
        $q = trim((string) $request->get('q', ''));

        if ($q === '') {
            return redirect()->back()->with('error', 'Escribe una cédula, credencial o nombre para buscar.');
        }

        $digitsOnly = preg_replace('/\D+/', '', $q) ?? '';
        $withRelations = [
            'oficiales_cargos.cargo',
            'cargos_administrativo',
            'parroquia.municipio',
            'oficiales_academicos' => function ($q) {
                $q->orderByRaw('fecha_fin IS NULL')
                    ->orderByDesc('fecha_fin')
                    ->orderByDesc('id');
            },
            'oficiales_familiares',
        ];

        // Coincidencia exacta por cédula o credencial
        $oficial = Oficiale::with($withRelations)
            ->where(function ($query) use ($q, $digitsOnly) {
                $query->where('documento_identidad', $q)
                    ->orWhere('numero_placa', $q);
                if ($digitsOnly !== '' && $digitsOnly !== $q) {
                    $query->orWhere('documento_identidad', $digitsOnly);
                }
            })
            ->first();

        if ($oficial) {
            return view('admin.officers.ficha', [
                'title' => 'Ficha — '.$oficial->nombre_completo,
                'oficial' => $oficial,
                'leftImagePath' => $this->logoDataUri(),
            ]);
        }

        $resultados = Oficiale::query()
            ->where(function ($query) use ($q, $digitsOnly) {
                $query->where('nombre_completo', 'like', "%{$q}%")
                    ->orWhere('documento_identidad', 'like', "%{$q}%")
                    ->orWhere('numero_placa', 'like', "%{$q}%");
                if ($digitsOnly !== '' && strlen($digitsOnly) >= 3) {
                    $query->orWhere('documento_identidad', 'like', "%{$digitsOnly}%");
                }
            })
            ->orderBy('nombre_completo')
            ->limit(50)
            ->get();

        if ($resultados->count() === 1) {
            $oficial = Oficiale::with($withRelations)->findOrFail($resultados->first()->id);

            return view('admin.officers.ficha', [
                'title' => 'Ficha — '.$oficial->nombre_completo,
                'oficial' => $oficial,
                'leftImagePath' => $this->logoDataUri(),
            ]);
        }

        return view('admin.officers.search-results', [
            'title' => 'Resultados de búsqueda',
            'q' => $q,
            'resultados' => $resultados,
            'leftImagePath' => $this->logoDataUri(),
        ]);
    }

    public function ficha(int $id): View
    {
        $oficial = Oficiale::with([
            'oficiales_cargos.cargo',
            'cargos_administrativo',
            'parroquia.municipio',
            'oficiales_academicos' => function ($q) {
                $q->orderByRaw('fecha_fin IS NULL')
                    ->orderByDesc('fecha_fin')
                    ->orderByDesc('id');
            },
            'oficiales_familiares',
        ])->findOrFail($id);

        return view('admin.officers.ficha', [
            'title' => 'Ficha — '.$oficial->nombre_completo,
            'oficial' => $oficial,
            'leftImagePath' => $this->logoDataUri(),
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'documento_identidad' => ['required', 'string', 'max:50'],
            'nombre_completo' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date'],
            'sexo' => ['nullable', 'in:Masculino,Femenino'],
            'tipo_sangre' => ['nullable', 'string', 'max:3'],
            'estado_civil' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string'],
            'tipo_vivienda' => ['nullable', 'in:Propia,Alquilada,No posee'],
            'direccion_vivienda' => ['nullable', 'string'],
            'sabe_conducir' => ['nullable', 'in:0,1'],
            'tipos_conduccion' => ['nullable', 'array'],
            'tipos_conduccion.*' => ['string', 'in:Vehículo,Moto,Jack,Grúa'],
            'centro_votacion' => ['nullable', 'string'],
            'parroquia_id' => ['nullable', 'integer', 'exists:parroquias,id'],
            'numero_placa' => ['nullable', 'string', 'max:255'],
            'fecha_ingreso' => ['required', 'date'],
            'estatus' => ['required', 'string', 'max:50'],
            'cargo_administrativo_id' => ['nullable', 'integer'],
            'talla_camisa' => ['nullable', 'string', 'max:255'],
            'talla_pantalon' => ['nullable', 'string', 'max:10'],
            'talla_zapatos' => ['nullable', 'string', 'max:255'],
            'talla_kepin_toka' => ['nullable', 'string', 'max:255'],
            'talla_saco' => ['nullable', 'string', 'max:255'],
            'talla_falda' => ['nullable', 'string', 'max:255'],
            'talla_gorra' => ['nullable', 'string', 'max:255'],
            'talla_tacon' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'telefono_residencial' => ['nullable', 'string', 'max:50'],
            'correo_electronico' => ['nullable', 'email', 'max:100'],
            'fotografia' => ['nullable', 'image', 'max:5120'],
        ]);

        foreach (['cargo_administrativo_id', 'parroquia_id'] as $fk) {
            if (empty($data[$fk])) {
                $data[$fk] = null;
            }
        }

        if (($data['tipo_vivienda'] ?? null) === 'No posee' || empty($data['tipo_vivienda'])) {
            $data['direccion_vivienda'] = null;
        }

        if (! filled(trim((string) ($data['numero_placa'] ?? '')))) {
            $data['numero_placa'] = null;
        }

        $data['sabe_conducir'] = (string) ($data['sabe_conducir'] ?? '0') === '1';
        if (! $data['sabe_conducir']) {
            $data['tipos_conduccion'] = null;
        } else {
            $data['tipos_conduccion'] = array_values(array_unique($data['tipos_conduccion'] ?? []));
            if ($data['tipos_conduccion'] === []) {
                $data['tipos_conduccion'] = null;
            }
        }

        return $data;
    }

    private function storePhoto(Request $request, Oficiale $oficial): void
    {
        if (! $request->hasFile('fotografia') || ! $request->file('fotografia')->isValid()) {
            return;
        }

        $folderPath = 'fotografias/'.$oficial->id;
        $oldFoto = $oficial->fotografia;

        try {
            $filePath = $request->file('fotografia')->store($folderPath, 'public');
            $oficial->fotografia = $filePath;
            $oficial->save();

            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
        } catch (\Throwable $e) {
            Log::error('Error al guardar fotografía', ['error' => $e->getMessage()]);
        }
    }

    private function logoDataUri(): string
    {
        $path = public_path('images/icon/logo.png');
        if (! is_file($path)) {
            return '';
        }

        return 'data:image/png;base64,'.base64_encode((string) file_get_contents($path));
    }
}
