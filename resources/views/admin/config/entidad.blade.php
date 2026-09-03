@extends('layouts.app')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">Configuraciones</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Entidad</h1>
        <p class="mt-1 text-sm text-slate-500">
            Nombres que aparecen en boletas y radiogramas (comandante general y director de talento humano).
        </p>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 bg-slate-50/80 px-4 py-3">
        <h2 class="mb-0 text-base font-semibold text-slate-800">Datos institucionales</h2>
    </div>
    <div class="p-4 sm:p-5">
        <form id="form-entidad">
            <div class="alert alert-info p-2 border mb-4">
                <p class="mb-0 text-muted">
                    Estos nombres se usan en la firma de la boleta de vacaciones (comandante / director general)
                    y en radiogramas (director de talento humano).
                </p>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="director_general">Comandante / Director general</label>
                    <input type="text" class="form-control" id="director_general" name="director_general"
                           placeholder="Ejemplo: CNEL. Juan Pérez"
                           value="{{ old('director_general', $entidad->director_general) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="rrhh">Director de talento humano / RRHH</label>
                    <input type="text" class="form-control" id="rrhh" name="rrhh"
                           placeholder="Ejemplo: Abg. María Rodríguez"
                           value="{{ old('rrhh', $entidad->rrhh) }}">
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var apiBase = @json(url('api'));

    $('#form-entidad').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');

        fetch(apiBase + '/entidad', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
            .then(function (r) {
                return r.json().then(function (data) {
                    return { ok: r.ok, data: data };
                });
            })
            .then(function (res) {
                if (!res.ok) {
                    var msg = res.data.msj || res.data.message || 'No se pudo guardar';
                    if (res.data.errors) {
                        msg = Object.values(res.data.errors).flat().join('\n');
                    }
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    return;
                }
                Swal.fire({ icon: 'success', title: res.data.msj || 'Guardado' });
                if (res.data.entidad) {
                    $('#director_general').val(res.data.entidad.director_general || '');
                    $('#rrhh').val(res.data.entidad.rrhh || '');
                }
            })
            .catch(function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo conectar con el servidor.' });
            });
    });
});
</script>
@endsection
