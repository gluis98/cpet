@php
    $isEdit = $oficial->exists;
    $fotoUrl = ($isEdit && $oficial->fotografia)
        ? asset('storage/'.$oficial->fotografia)
        : null;
@endphp

<input type="hidden" name="tipo_funcionario" value="{{ $tipoFuncionario }}">

<div class="officer-form">
    <div class="mb-4 rounded-xl border border-brand-100 bg-gradient-to-r from-brand-50 to-white px-4 py-3 text-sm text-brand-800">
        <i class="fas fa-info-circle mr-1 text-brand-500"></i>
        Campos con <span class="font-semibold text-accent-600">*</span> son obligatorios · Tipo:
        <span class="font-semibold">{{ $tipoFuncionario }}</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-[280px_minmax(0,1fr)]">
        {{-- Foto --}}
        <aside class="lg:sticky lg:top-24 lg:self-start">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md shadow-slate-200/60">
                <div class="border-b border-slate-100 bg-gradient-to-r from-brand-900 to-brand-700 px-4 py-3">
                    <p class="text-sm font-semibold text-white">Fotografía</p>
                    <p class="text-xs text-white/65">JPG, PNG · máx. 5 MB</p>
                </div>

                <div class="p-4">
                    <label for="fotografia" id="photo-dropzone"
                           class="photo-dropzone group relative mx-auto block aspect-square w-full max-w-[240px] cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-b from-slate-50 to-slate-100 transition hover:border-brand-400 hover:from-brand-50 hover:to-white">
                        <img id="photo-preview"
                             src="{{ $fotoUrl ?? '' }}"
                             alt="Vista previa"
                             class="absolute inset-0 h-full w-full object-cover {{ $fotoUrl ? '' : 'hidden' }}">

                        <div id="photo-placeholder" class="{{ $fotoUrl ? 'hidden' : '' }} photo-placeholder absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                            <span class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-100 text-brand-700 shadow-sm transition group-hover:scale-105">
                                <i class="fas fa-camera text-xl"></i>
                            </span>
                            <span class="text-sm font-semibold text-slate-700">Subir foto</span>
                            <span class="mt-1 text-xs text-slate-500">Arrastra o haz clic</span>
                        </div>

                        <div id="photo-overlay" class="absolute inset-0 hidden items-end justify-center bg-gradient-to-t from-brand-900/80 via-brand-900/20 to-transparent p-3 opacity-0 transition group-hover:opacity-100 {{ $fotoUrl ? 'flex' : '' }}">
                            <span class="rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-brand-800 shadow">
                                <i class="fas fa-sync-alt mr-1"></i> Cambiar
                            </span>
                        </div>
                    </label>

                    <input type="file" id="fotografia" name="fotografia" accept="image/*" class="sr-only">

                    <div class="mt-3 flex items-center justify-between gap-2">
                        <p id="photo-filename" class="truncate text-xs text-slate-500">
                            {{ $fotoUrl ? 'Foto actual cargada' : 'Sin imagen seleccionada' }}
                        </p>
                        <button type="button" id="photo-clear" class="btn btn-sm btn-secondary {{ $fotoUrl ? '' : 'hidden' }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Pestañas --}}
        <div class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md shadow-slate-200/60">
            <div class="officer-tabs border-b border-slate-200 bg-slate-50/80 px-2 pt-2 sm:px-3" role="tablist">
                <div class="flex flex-wrap gap-1">
                    <button type="button" class="officer-tab is-active" data-tab="personales" role="tab" aria-selected="true">
                        <i class="fas fa-user"></i><span>Personales</span>
                    </button>
                    <button type="button" class="officer-tab" data-tab="laborales" role="tab" aria-selected="false">
                        <i class="fas fa-id-badge"></i><span>Laborales</span>
                    </button>
                    <button type="button" class="officer-tab" data-tab="vestuario" role="tab" aria-selected="false">
                        <i class="fas fa-tshirt"></i><span>Vestuario</span>
                    </button>
                    <button type="button" class="officer-tab" data-tab="vivienda" role="tab" aria-selected="false">
                        <i class="fas fa-home"></i><span>Vivienda</span>
                    </button>
                    <button type="button" class="officer-tab" data-tab="conduccion" role="tab" aria-selected="false">
                        <i class="fas fa-car"></i><span>Conducción</span>
                    </button>
                    <button type="button" class="officer-tab" data-tab="contacto" role="tab" aria-selected="false">
                        <i class="fas fa-phone-alt"></i><span>Contacto</span>
                    </button>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                {{-- Personales --}}
                <div class="officer-pane" id="pane-personales" role="tabpanel">
                    <h3 class="mb-4 text-base font-semibold text-slate-800">Datos personales</h3>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="documento_identidad">Documento de identidad <span class="text-accent-600">*</span></label>
                            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required
                                   value="{{ old('documento_identidad', $oficial->documento_identidad) }}"
                                   placeholder="Número de cédula">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nombre_completo">Nombre completo <span class="text-accent-600">*</span></label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required
                                   value="{{ old('nombre_completo', $oficial->nombre_completo) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento <span class="text-accent-600">*</span></label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required
                                   value="{{ old('fecha_nacimiento', optional($oficial->fecha_nacimiento)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="sexo">Sexo</label>
                            <select class="form-control" id="sexo" name="sexo">
                                <option value="">--- SELECCIONE ---</option>
                                @foreach (\App\Models\Oficiale::SEXOS as $sx)
                                    <option value="{{ $sx }}" @selected(old('sexo', $oficial->sexo) === $sx)>{{ $sx }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="tipo_sangre">Tipo de sangre</label>
                            <select class="form-control" id="tipo_sangre" name="tipo_sangre">
                                <option value="">--- SELECCIONE ---</option>
                                @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $sangre)
                                    <option value="{{ $sangre }}" @selected(old('tipo_sangre', $oficial->tipo_sangre) === $sangre)>{{ $sangre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="estado_civil">Estado civil</label>
                            <select class="form-control" id="estado_civil" name="estado_civil">
                                @foreach (['Soltero','Casado','Divorciado','Viudo','Separado','Unión libre','Concubinato'] as $ec)
                                    <option value="{{ $ec }}" @selected(old('estado_civil', $oficial->estado_civil) === $ec)>{{ $ec }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="centro_votacion">Centro de votación</label>
                            <input type="text" class="form-control" id="centro_votacion" name="centro_votacion"
                                   value="{{ old('centro_votacion', $oficial->centro_votacion) }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="direccion">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="3">{{ old('direccion', $oficial->direccion) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Laborales --}}
                <div class="officer-pane hidden" id="pane-laborales" role="tabpanel" hidden>
                    <h3 class="mb-4 text-base font-semibold text-slate-800">Datos laborales / policiales</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="numero_placa">Número de credencial</label>
                            <input type="text" class="form-control" id="numero_placa" name="numero_placa"
                                   placeholder="Opcional — Sin Credencial Asignada"
                                   value="{{ old('numero_placa', $oficial->numero_placa) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="fecha_ingreso">Fecha de ingreso <span class="text-accent-600">*</span></label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required
                                   value="{{ old('fecha_ingreso', optional($oficial->fecha_ingreso)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="estatus">Estatus <span class="text-accent-600">*</span></label>
                            <select class="form-control" id="estatus" name="estatus" required>
                                @foreach (['Operativo','No Operativo','En Reposo','Retirado','Suspendido','Jubilado','Fallecido','URRA'] as $st)
                                    <option value="{{ $st }}" @selected(old('estatus', $oficial->estatus ?? 'Operativo') === $st)>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tipo_funcionario_display">Tipo de funcionario <span class="text-accent-600">*</span></label>
                            <input type="text" class="form-control" id="tipo_funcionario_display" value="{{ $tipoFuncionario }}" readonly>
                            <small class="text-muted">Policial, Administrativo u Obrero (según el módulo donde se creó).</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="cargo_administrativo_id">Cargo</label>
                            <div class="input-group">
                                <select class="form-control" id="cargo_administrativo_id" name="cargo_administrativo_id">
                                    <option value="">--- SELECCIONE ---</option>
                                    @foreach ($cargosAdministrativos as $ca)
                                        <option value="{{ $ca->id }}" @selected((string) old('cargo_administrativo_id', $oficial->cargo_administrativo_id) === (string) $ca->id)>{{ $ca->nombre_cargo }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-secondary" id="btn-add-cargo-admin" title="Agregar cargo">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">Si no aparece, pulsa + para agregarlo.</small>
                        </div>
                    </div>
                </div>

                {{-- Vestuario --}}
                <div class="officer-pane hidden" id="pane-vestuario" role="tabpanel" hidden>
                    <h3 class="mb-4 text-base font-semibold text-slate-800">Datos de vestuario</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="talla_camisa">Talla de camisa</label>
                            <input type="text" class="form-control" name="talla_camisa" id="talla_camisa" value="{{ old('talla_camisa', $oficial->talla_camisa) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="talla_pantalon">Talla de pantalón</label>
                            <input type="text" class="form-control" name="talla_pantalon" id="talla_pantalon" value="{{ old('talla_pantalon', $oficial->talla_pantalon) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="talla_zapatos">Talla de zapatos</label>
                            <input type="text" class="form-control" name="talla_zapatos" id="talla_zapatos" value="{{ old('talla_zapatos', $oficial->talla_zapatos) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="talla_kepin_toka">Talla de KEPIN/TOKA</label>
                            <input type="text" class="form-control" name="talla_kepin_toka" id="talla_kepin_toka" value="{{ old('talla_kepin_toka', $oficial->talla_kepin_toka) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="talla_saco">Talla de saco</label>
                            <input type="text" class="form-control" name="talla_saco" id="talla_saco" value="{{ old('talla_saco', $oficial->talla_saco) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="talla_falda">Talla de falda</label>
                            <input type="text" class="form-control" name="talla_falda" id="talla_falda" value="{{ old('talla_falda', $oficial->talla_falda) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="talla_gorra">Talla de gorra</label>
                            <input type="text" class="form-control" name="talla_gorra" id="talla_gorra" value="{{ old('talla_gorra', $oficial->talla_gorra) }}">
                        </div>
                    </div>
                </div>

                {{-- Vivienda --}}
                <div class="officer-pane hidden" id="pane-vivienda" role="tabpanel" hidden>
                    <h3 class="mb-4 text-base font-semibold text-slate-800">Situación de vivienda</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tipo_vivienda">¿Posee vivienda?</label>
                            <select class="form-control" id="tipo_vivienda" name="tipo_vivienda">
                                <option value="">--- SELECCIONE ---</option>
                                @foreach (\App\Models\Oficiale::TIPOS_VIVIENDA as $tv)
                                    <option value="{{ $tv }}" @selected(old('tipo_vivienda', $oficial->tipo_vivienda) === $tv)>{{ $tv }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="direccion-vivienda-wrap">
                            <label class="form-label" for="direccion_vivienda">Dirección de la vivienda</label>
                            <textarea class="form-control" id="direccion_vivienda" name="direccion_vivienda" rows="3"
                                      placeholder="Indique la dirección completa de la vivienda">{{ old('direccion_vivienda', $oficial->direccion_vivienda) }}</textarea>
                            <p class="mt-1 text-xs text-slate-500">Solo aplica si la vivienda es propia o alquilada.</p>
                        </div>
                    </div>
                </div>

                {{-- Conducción --}}
                @php
                    $tiposConduccionSel = old('tipos_conduccion', $oficial->tipos_conduccion ?? []);
                    if (! is_array($tiposConduccionSel)) {
                        $tiposConduccionSel = [];
                    }
                    $sabeConducir = old('sabe_conducir', $oficial->sabe_conducir ? '1' : '0');
                @endphp
                <div class="officer-pane hidden" id="pane-conduccion" role="tabpanel" hidden>
                    <h3 class="mb-4 text-base font-semibold text-slate-800">Datos de conducción</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="sabe_conducir">¿Sabe conducir?</label>
                            <select class="form-control" id="sabe_conducir" name="sabe_conducir">
                                <option value="0" @selected((string) $sabeConducir === '0')>No</option>
                                <option value="1" @selected((string) $sabeConducir === '1')>Sí</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="tipos-conduccion-wrap">
                            <label class="form-label d-block mb-2">Tipos de vehículos que conduce</label>
                            <div class="row">
                                @foreach (\App\Models\Oficiale::TIPOS_CONDUCCION as $tipoVeh)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check border rounded px-3 py-2">
                                            <input class="form-check-input" type="checkbox"
                                                   name="tipos_conduccion[]"
                                                   id="tipo_cond_{{ Str::slug($tipoVeh) }}"
                                                   value="{{ $tipoVeh }}"
                                                   @checked(in_array($tipoVeh, $tiposConduccionSel, true))>
                                            <label class="form-check-label" for="tipo_cond_{{ Str::slug($tipoVeh) }}">
                                                {{ $tipoVeh }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Seleccione uno o varios tipos.</p>
                        </div>
                    </div>
                </div>

                {{-- Contacto --}}
                <div class="officer-pane hidden" id="pane-contacto" role="tabpanel" hidden>
                    <h3 class="mb-4 text-base font-semibold text-slate-800">Datos de contacto</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="telefono">Teléfono <span class="text-accent-600">*</span></label>
                            <input type="text" class="form-control" name="telefono" id="telefono" required
                                   value="{{ old('telefono', $oficial->telefono) }}" placeholder="Ejemplo: +58 412 1234567">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="telefono_residencial">Teléfono residencial</label>
                            <input type="text" class="form-control" name="telefono_residencial" id="telefono_residencial"
                                   value="{{ old('telefono_residencial', $oficial->telefono_residencial) }}" placeholder="Opcional">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="correo_electronico">Correo electrónico <span class="text-accent-600">*</span></label>
                            <input type="email" class="form-control" name="correo_electronico" id="correo_electronico" required
                                   value="{{ old('correo_electronico', $oficial->correo_electronico) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 bg-slate-50/70 px-4 py-4 sm:px-6">
                <p class="text-xs text-slate-500">
                    <i class="fas fa-shield-alt mr-1 text-brand-500"></i>
                    Revisa cada pestaña antes de guardar
                </p>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-check-circle"></i>
                    {{ $isEdit ? 'Actualizar funcionario' : 'Guardar funcionario' }}
                </button>
            </div>
        </div>
    </div>
</div>
