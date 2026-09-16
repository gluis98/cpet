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
    .ficha-print-sheet { display: none; }

    @media (max-width: 768px) {
        .ficha-layout { grid-template-columns: 1fr; }
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 7mm;
        }

        html, body {
            background: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 8.5pt;
            color: #0f172a;
        }

        #app-sidebar,
        #sidebar-overlay,
        #sidebar-open,
        header,
        footer,
        .no-print,
        .app-content-shell > div > div.border-b,
        .ficha-layout {
            display: none !important;
        }

        .app-content-shell,
        .app-content-shell > div,
        main,
        main > div,
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            min-height: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            border: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: #fff !important;
        }

        .ficha-print-sheet {
            display: block !important;
        }

        .print-top {
            display: grid;
            grid-template-columns: 32mm 1fr;
            gap: 3.5mm;
            align-items: start;
            margin-bottom: 3mm;
            padding-bottom: 2.5mm;
            border-bottom: 1.5pt solid #1a3a5c;
        }

        .print-photo {
            width: 32mm;
            height: 40mm;
            object-fit: cover;
            border: 1.2pt solid #1a3a5c;
            display: block;
            background: #f1f5f9;
        }

        .print-identity h1 {
            margin: 0 0 1.5mm;
            font-size: 13pt;
            line-height: 1.15;
            color: #0a1a2e;
        }

        .print-identity .print-sub {
            margin: 0;
            font-size: 8.5pt;
            color: #334155;
            line-height: 1.35;
        }

        .print-identity .print-badges {
            margin-top: 2mm;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5mm;
        }

        .print-badge {
            display: inline-block;
            border: 0.7pt solid #1a3a5c;
            border-radius: 2px;
            padding: 0.6mm 1.8mm;
            font-size: 7.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #1a3a5c;
        }

        .print-block {
            margin: 0 0 2.2mm;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .print-block h2 {
            margin: 0 0 1.2mm;
            padding: 0.8mm 1.5mm;
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #fff;
            background: #1a3a5c;
        }

        .print-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1mm 2.5mm;
            padding: 1.2mm 1.5mm 1.5mm;
            border: 0.7pt solid #cbd5e1;
            border-top: 0;
        }

        .print-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .print-grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .print-item {
            min-width: 0;
            line-height: 1.2;
        }

        .print-item.span-2 { grid-column: span 2; }
        .print-item.span-3 { grid-column: span 3; }
        .print-item.span-4,
        .print-item.full { grid-column: 1 / -1; }

        .print-item .k {
            display: block;
            font-size: 6.2pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            margin-bottom: 0.2mm;
        }

        .print-item .v {
            display: block;
            font-size: 8pt;
            color: #0f172a;
            word-break: break-word;
        }

        .print-academy {
            font-size: 7.5pt;
            line-height: 1.25;
            padding: 0.8mm 0;
            border-bottom: 0.5pt dotted #cbd5e1;
        }

        .print-academy:last-child { border-bottom: 0; }

        .print-two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.2mm;
        }

        .print-two-cols .print-block { margin-bottom: 0; }
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
    $foto = $oficial->fotoUrl() ?: asset('images/oficial-icon.png');
    $academicos = $oficial->oficiales_academicos ?? collect();
    $cantidadHijos = ($oficial->oficiales_familiares ?? collect())
        ->filter(fn ($f) => stripos((string) $f->parentesco, 'Hijo') !== false)
        ->count();
    $tipoSlug = array_search($oficial->tipo_funcionario ?? 'Policial', \App\Models\Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial';
    $tiposConduccion = ! empty($oficial->tipos_conduccion) ? implode(', ', $oficial->tipos_conduccion) : 'Sin especificar';
@endphp

<div class="container-fluid mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <h2 class="mb-0">Ficha del funcionario</h2>
        <div class="d-flex align-items-center gap-2">
            @include('admin.officers._submodulos', [
                'oficialId' => $oficial->id,
                'tipoSlug' => $tipoSlug,
                'btnClass' => 'btn btn-dark btn-sm dropdown-toggle',
                'btnLabel' => 'Submódulos',
            ])
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

    {{-- Vista pantalla (pestañas) --}}
    <div class="ficha-layout" id="ficha-screen">
        <aside class="ficha-photo-wrap">
            <img src="{{ $foto }}" alt="Fotografía" class="ficha-photo-square" onerror="this.src='{{ asset('images/oficial-icon.png') }}'">
            <div class="ficha-meta">
                <strong>{{ $oficial->nombre_completo }}</strong><br>
                C.I. {{ $oficial->documento_identidad ?? 'N/A' }}<br>
                {{ $oficial->tipo_funcionario ?? 'Policial' }}
            </div>
        </aside>

        <div>
            <ul class="nav nav-tabs ficha-tabs mb-3 no-print" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-personales" role="tab">Datos personales</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-laborales" role="tab">Datos laborales</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-academica" role="tab">Formación académica</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-vivienda" role="tab">Vivienda</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-conduccion" role="tab">Conducción</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-tallas" role="tab">Tallas</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-contacto" role="tab">Contacto</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-personales" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field"><label>Cédula</label><span>{{ $oficial->documento_identidad ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Carnet de la Patria (código)</label><span>{{ $oficial->carnet_patria ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Carnet de la Patria (serial)</label><span>{{ $oficial->carnet_patria_serial ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Nombre completo</label><span>{{ $oficial->nombre_completo ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Fecha de nacimiento</label><span>{{ optional($oficial->fecha_nacimiento)->format('d/m/Y') ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Sexo</label><span>{{ $oficial->sexo ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Edad</label><span>{{ $edad }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Tipo de sangre</label><span>{{ $oficial->tipo_sangre ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Estado civil</label><span>{{ $oficial->estado_civil ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Cantidad de hijos</label><span>{{ $cantidadHijos }}</span></div>
                        <div class="col-md-12 ficha-field"><label>Dirección</label><span>{{ $oficial->direccion ?? 'N/A' }}</span></div>
                        <div class="col-md-12 ficha-field"><label>Centro de votación</label><span>{{ $oficial->centro_votacion_catalogo->nombre ?? $oficial->centro_votacion ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Municipio</label><span>{{ optional($oficial->parroquia?->municipio)->descripcion ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Parroquia</label><span>{{ optional($oficial->parroquia)->descripcion ?? 'N/A' }}</span></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-laborales" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 ficha-field"><label>Tipo de cargo</label><span>{{ $oficial->tipo_funcionario ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Credencial</label><span>{{ \App\Models\Oficiale::displayNumeroPlaca($oficial->numero_placa) }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Fecha de ingreso</label><span>{{ optional($oficial->fecha_ingreso)->format('d/m/Y') ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Estatus</label><span>{{ $oficial->estatus ?? 'N/A' }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Jerarquía actual</label><span>{{ $cargoActual }}</span></div>
                        <div class="col-md-6 ficha-field"><label>Estación de servicio</label><span>{{ optional($oficial->estacion_servicio)->estacion ?? 'N/A' }}</span></div>
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
                                <div class="mt-2 no-print">
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
                                <span>{{ $tiposConduccion }}</span>
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

    {{-- Vista impresión (bloques compactos, una hoja) --}}
    <div class="ficha-print-sheet" id="ficha-print">
        <div class="print-top">
            <img class="print-photo" src="{{ $foto }}" alt="Fotografía" onerror="this.src='{{ asset('images/oficial-icon.png') }}'">
            <div class="print-identity">
                <h1>{{ $oficial->nombre_completo ?? 'Sin nombre' }}</h1>
                <p class="print-sub">
                    <strong>C.I.</strong> {{ $oficial->documento_identidad ?? 'N/A' }}
                    &nbsp;·&nbsp; <strong>Credencial</strong> {{ \App\Models\Oficiale::displayNumeroPlaca($oficial->numero_placa) }}
                    &nbsp;·&nbsp; <strong>Ingreso</strong> {{ optional($oficial->fecha_ingreso)->format('d/m/Y') ?? 'N/A' }}
                </p>
                <div class="print-badges">
                    <span class="print-badge">{{ $oficial->tipo_funcionario ?? 'Policial' }}</span>
                    <span class="print-badge">{{ $oficial->estatus ?? 'N/A' }}</span>
                    <span class="print-badge">{{ $cargoActual }}</span>
                </div>
            </div>
        </div>

        <section class="print-block">
            <h2>Datos personales</h2>
            <div class="print-grid">
                <div class="print-item"><span class="k">Cédula</span><span class="v">{{ $oficial->documento_identidad ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Sexo</span><span class="v">{{ $oficial->sexo ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Nacimiento</span><span class="v">{{ optional($oficial->fecha_nacimiento)->format('d/m/Y') ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Edad</span><span class="v">{{ $edad }}</span></div>
                <div class="print-item"><span class="k">Tipo sangre</span><span class="v">{{ $oficial->tipo_sangre ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Estado civil</span><span class="v">{{ $oficial->estado_civil ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Hijos</span><span class="v">{{ $cantidadHijos }}</span></div>
                <div class="print-item"><span class="k">Carnet código</span><span class="v">{{ $oficial->carnet_patria ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Carnet serial</span><span class="v">{{ $oficial->carnet_patria_serial ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Municipio</span><span class="v">{{ optional($oficial->parroquia?->municipio)->descripcion ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Parroquia</span><span class="v">{{ optional($oficial->parroquia)->descripcion ?? 'N/A' }}</span></div>
                <div class="print-item span-2"><span class="k">Centro de votación</span><span class="v">{{ $oficial->centro_votacion_catalogo->nombre ?? $oficial->centro_votacion ?? 'N/A' }}</span></div>
                <div class="print-item full"><span class="k">Dirección</span><span class="v">{{ $oficial->direccion ?? 'N/A' }}</span></div>
            </div>
        </section>

        <section class="print-block">
            <h2>Datos laborales</h2>
            <div class="print-grid">
                <div class="print-item"><span class="k">Tipo funcionario</span><span class="v">{{ $oficial->tipo_funcionario ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Estatus</span><span class="v">{{ $oficial->estatus ?? 'N/A' }}@if($oficial->estatus === 'Retirado' && $oficial->tipo_retiro) ({{ $oficial->tipo_retiro }})@endif</span></div>
                <div class="print-item"><span class="k">Fecha ingreso</span><span class="v">{{ optional($oficial->fecha_ingreso)->format('d/m/Y') ?? 'N/A' }}</span></div>
                <div class="print-item"><span class="k">Credencial</span><span class="v">{{ \App\Models\Oficiale::displayNumeroPlaca($oficial->numero_placa) }}</span></div>
                <div class="print-item span-2"><span class="k">Jerarquía actual</span><span class="v">{{ $cargoActual }}</span></div>
                <div class="print-item span-2"><span class="k">Cargo</span><span class="v">{{ optional($oficial->cargos_administrativo)->nombre_cargo ?? 'N/A' }}</span></div>
                <div class="print-item full"><span class="k">Estación de servicio</span><span class="v">{{ optional($oficial->estacion_servicio)->estacion ?? 'N/A' }}</span></div>
            </div>
        </section>

        <section class="print-block">
            <h2>Formación académica</h2>
            <div class="print-grid" style="display:block;">
                @forelse ($academicos->take(4) as $index => $academico)
                    <div class="print-academy">
                        <strong>{{ $academico->titulo ?: $academico->tipo_formacion }}</strong>
                        — {{ $academico->tipo_formacion }}
                        · {{ $academico->institucion ?: 'Sin institución' }}
                        · {{ $academico->fecha_fin ? $academico->fecha_fin->format('Y') : 'S/F' }}
                        @if ($index === 0 && $academico->fecha_fin)
                            · <em>Título actual</em>
                        @endif
                    </div>
                @empty
                    <div class="print-academy">Sin formación académica registrada.</div>
                @endforelse
                @if ($academicos->count() > 4)
                    <div class="print-academy"><em>+ {{ $academicos->count() - 4 }} registro(s) adicional(es) en el sistema</em></div>
                @endif
            </div>
        </section>

        <div class="print-two-cols">
            <section class="print-block">
                <h2>Conducción y vivienda</h2>
                <div class="print-grid print-grid-2">
                    <div class="print-item"><span class="k">¿Sabe conducir?</span><span class="v">{{ $oficial->sabe_conducir ? 'Sí' : 'No' }}</span></div>
                    <div class="print-item"><span class="k">Tipo vivienda</span><span class="v">{{ $oficial->tipo_vivienda ?? 'N/A' }}</span></div>
                    <div class="print-item full"><span class="k">Tipos de vehículos</span><span class="v">{{ $oficial->sabe_conducir ? $tiposConduccion : 'N/A' }}</span></div>
                    @if (in_array($oficial->tipo_vivienda, ['Propia', 'Alquilada'], true))
                        <div class="print-item full"><span class="k">Dirección vivienda</span><span class="v">{{ $oficial->direccion_vivienda ?? 'N/A' }}</span></div>
                    @endif
                </div>
            </section>

            <section class="print-block">
                <h2>Contacto</h2>
                <div class="print-grid print-grid-2">
                    <div class="print-item"><span class="k">Teléfono</span><span class="v">{{ $oficial->telefono ?? 'N/A' }}</span></div>
                    <div class="print-item"><span class="k">Residencial</span><span class="v">{{ $oficial->telefono_residencial ?? 'N/A' }}</span></div>
                    <div class="print-item full"><span class="k">Correo</span><span class="v">{{ $oficial->correo_electronico ?? 'N/A' }}</span></div>
                </div>
            </section>
        </div>

        <section class="print-block" style="margin-top:2.2mm;">
            <h2>Tallas</h2>
            <div class="print-grid" style="grid-template-columns: repeat(8, minmax(0, 1fr));">
                <div class="print-item"><span class="k">Camisa</span><span class="v">{{ $oficial->talla_camisa ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Pantalón</span><span class="v">{{ $oficial->talla_pantalon ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Zapatos</span><span class="v">{{ $oficial->talla_zapatos ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Saco</span><span class="v">{{ $oficial->talla_saco ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Kepin</span><span class="v">{{ $oficial->talla_kepin_toka ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Tacón</span><span class="v">{{ $oficial->talla_tacon ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Falda</span><span class="v">{{ $oficial->talla_falda ?? '—' }}</span></div>
                <div class="print-item"><span class="k">Gorra</span><span class="v">{{ $oficial->talla_gorra ?? '—' }}</span></div>
            </div>
        </section>
    </div>
</div>
@endsection
