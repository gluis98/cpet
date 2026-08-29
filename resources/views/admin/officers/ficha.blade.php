@extends('layouts.app')

@section('styles')
<style>
    .ficha-layout {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 1.5rem;
        background: #fff;
        border: 1px solid #d9e2ec;
        border-radius: 8px;
        padding: 1.25rem;
    }
    .ficha-photo-wrap { text-align: center; }
    .ficha-photo-square {
        width: 180px;
        height: 220px;
        object-fit: cover;
        border: 2px solid #1a3a5c;
        background: #f1f5f9;
        display: block;
        margin: 0 auto 0.75rem;
    }
    .ficha-meta { font-size: 0.85rem; color: #475569; }
    .ficha-tabs .nav-link { color: #1a3a5c; font-weight: 600; }
    .ficha-tabs .nav-link.active { background: #1a3a5c; color: #fff; }
    .ficha-field { margin-bottom: 0.85rem; }
    .ficha-field label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.2rem;
    }
    .ficha-field span {
        display: block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.55rem 0.7rem;
        color: #0f172a;
    }
    .ficha-academy-item {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.85rem 1rem;
        margin-bottom: 0.75rem;
        background: #f8fafc;
    }
    .ficha-academy-item.is-actual {
        border-left: 4px solid #c4922e;
        background: #fffbeb;
    }
    @media (max-width: 768px) {
        .ficha-layout { grid-template-columns: 1fr; }
    }
    @media print {
        .no-print { display: none !important; }
        .ficha-layout { border: 0; }
    }
</style>
@endsection

@section('content')
@php
    $edad = 'N/A';
    if ($oficial->fecha_nacimiento) {
        $edad = $oficial->fecha_nacimiento->age;
    }
    $cargoActual = optional(optional($oficial->oficiales_cargos->firstWhere('is_actual', 1))->cargo)->nombre_cargo ?? 'N/A';
    $foto = $oficial->fotografia ? asset('storage/'.$oficial->fotografia) : asset('images/oficial-icon.png');
    $academicos = $oficial->oficiales_academicos ?? collect();
    $cantidadHijos = ($oficial->oficiales_familiares ?? collect())
        ->filter(fn ($f) => stripos((string) $f->parentesco, 'Hijo') !== false)
        ->count();
    $tipoSlug = array_search($oficial->tipo_funcionario ?? 'Policial', \App\Models\Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';
@endphp

<div class="container-fluid mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <h2 class="mb-0">Ficha del funcionario</h2>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('officers.form.edit', [$tipoSlug, $oficial->id]) }}"
               class="btn btn-sm btn-link text-muted px-2"
               title="Editar funcionario"
               style="text-decoration:none; font-weight:500;">
                <i class="far fa-edit"></i> Editar
            </a>
            <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Imprimir</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="ficha-layout" id="ficha-print">
        <aside class="ficha-photo-wrap">
            <img src="{{ $foto }}" alt="Fotografía" class="ficha-photo-square" onerror="this.src='{{ asset('images/oficial-icon.png') }}'">
            <div class="ficha-meta">
                <strong>{{ $oficial->nombre_completo }}</strong><br>
                C.I. {{ $oficial->documento_identidad ?? 'N/A' }}<br>
                {{ $oficial->tipo_funcionario ?? 'Policial' }}
            </div>
        </aside>

        <div>
            <ul class="nav nav-tabs ficha-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-personales" role="tab">Datos personales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-laborales" role="tab">Datos laborales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-academica" role="tab">Formación académica</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-vivienda" role="tab">Vivienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-conduccion" role="tab">Conducción</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-tallas" role="tab">Tallas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-contacto" role="tab">Contacto</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-personales" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field"><label>Cédula</label><span>{{ $oficial->documento_identidad ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Nombre completo</label><span>{{ $oficial->nombre_completo ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Fecha de nacimiento</label><span>{{ optional($oficial->fecha_nacimiento)->format('d/m/Y') ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Sexo</label><span>{{ $oficial->sexo ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Edad</label><span>{{ $edad }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Tipo de sangre</label><span>{{ $oficial->tipo_sangre ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Estado civil</label><span>{{ $oficial->estado_civil ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Cantidad de hijos</label><span>{{ $cantidadHijos }}</span></div>
                        <div class="col-md-12 ficha-field"><label>Dirección</label><span>{{ $oficial->direccion ?? 'N/A' }}</span></div>
                        <div class="col-md-12 ficha-field"><label>Centro de votación</label><span>{{ $oficial->centro_votacion ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-laborales" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field"><label>Tipo de cargo</label><span>{{ $oficial->tipo_funcionario ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Credencial</label><span>{{ \App\Models\Oficiale::displayNumeroPlaca($oficial->numero_placa) }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Fecha de ingreso</label><span>{{ optional($oficial->fecha_ingreso)->format('d/m/Y') ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Estatus</label><span>{{ $oficial->estatus ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Jerarquía actual</label><span>{{ $cargoActual }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Tipo de funcionario</label><span>{{ $oficial->tipo_funcionario ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Cargo</label><span>{{ optional($oficial->cargos_administrativo)->nombre_cargo ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-academica" role="tabpanel">
                    @forelse ($academicos as $index => $academico)
                        <div class="ficha-academy-item {{ $index === 0 && $academico->fecha_fin ? 'is-actual' : '' }}">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <strong>{{ $academico->titulo ?: $academico->tipo_formacion }}</strong>
                                    <span class="text-muted"> — {{ $academico->tipo_formacion }}</span>
                                    @if ($index === 0 && $academico->fecha_fin)
                                        <span class="badge badge-warning ml-1" style="background:#c4922e;color:#1a1408;">Título Actual</span>
                                    @endif
                                    <div class="text-muted small mt-1">{{ $academico->institucion ?: 'Sin institución' }}</div>
                                </div>
                                <div class="text-right">
                                    <span class="small text-muted d-block">Año de Graduación</span>
                                    <strong>{{ $academico->fecha_fin ? $academico->fecha_fin->format('Y') : 'S/F' }}</strong>
                                </div>
                            </div>
                            @if ($academico->descripcion)
                                <p class="mb-0 mt-2 small">{{ $academico->descripcion }}</p>
                            @endif
                            @if ($academico->documento_fondo_negro)
                                <div class="mt-2">
                                    <span class="small text-muted d-block mb-1">Documento (fondo negro)</span>
                                    @if (str_ends_with(strtolower($academico->documento_fondo_negro), '.pdf'))
                                        <a href="{{ asset('storage/' . $academico->documento_fondo_negro) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                            <i class="fas fa-file-pdf"></i> Ver PDF
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $academico->documento_fondo_negro) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $academico->documento_fondo_negro) }}" alt="Documento" class="img-thumbnail" style="max-height:140px;">
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">Sin formación académica registrada.</p>
                    @endforelse
                </div>

                <div class="tab-pane fade" id="tab-vivienda" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field"><label>Tipo de vivienda</label><span>{{ $oficial->tipo_vivienda ?? 'N/A' }}</span></div>
                        @if (in_array($oficial->tipo_vivienda, ['Propia', 'Alquilada'], true))
                            <div class="col-md-12 ficha-field"><label>Dirección de la vivienda</label><span>{{ $oficial->direccion_vivienda ?? 'N/A' }}</span></div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-conduccion" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field">
                            <label>¿Sabe conducir?</label>
                            <span>{{ $oficial->sabe_conducir ? 'Sí' : 'No' }}</span>
                        </div>
                        @if ($oficial->sabe_conducir)
                            <div class="col-md-12 ficha-field">
                                <label>Tipos de vehículos</label>
                                <span>{{ !empty($oficial->tipos_conduccion) ? implode(', ', $oficial->tipos_conduccion) : 'Sin especificar' }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-tallas" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 ficha-field"><label>Camisa</label><span>{{ $oficial->talla_camisa ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Pantalón</label><span>{{ $oficial->talla_pantalon ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Zapatos</label><span>{{ $oficial->talla_zapatos ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Saco</label><span>{{ $oficial->talla_saco ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Kepin/Toka</label><span>{{ $oficial->talla_kepin_toka ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Tacón</label><span>{{ $oficial->talla_tacon ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Falda</label><span>{{ $oficial->talla_falda ?? 'N/A' }}</span></div>
                        <div class="col-md-4 ficha-field"><label>Gorra</label><span>{{ $oficial->talla_gorra ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-contacto" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field"><label>Teléfono</label><span>{{ $oficial->telefono ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Teléfono residencial</label><span>{{ $oficial->telefono_residencial ?? 'N/A' }}</span></div>
                        <div class="col-md-12 ficha-field"><label>Correo electrónico</label><span>{{ $oficial->correo_electronico ?? 'N/A' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
