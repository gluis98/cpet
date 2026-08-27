@extends('layouts.app')

@section('styles')
<style>
    .icap-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 1rem;
        border: 0;
        border-radius: 0.75rem 0.75rem 0 0;
        background: transparent;
        color: #64748b;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
    }
    .icap-tab:hover { color: #1a4574; background: rgba(255,255,255,.7); }
    .icap-tab.is-active {
        color: #0f2744;
        background: #fff;
        position: relative;
    }
    .icap-tab.is-active::after {
        content: "";
        position: absolute;
        left: .75rem; right: .75rem; bottom: 0;
        height: 3px; border-radius: 999px;
        background: linear-gradient(90deg, #c4922e, #d4a84b);
    }
    .icap-tab__count {
        min-width: 1.35rem;
        border-radius: 999px;
        padding: .1rem .45rem;
        font-size: .7rem;
        font-weight: 700;
        background: #e2e8f0;
        color: #475569;
    }
    .icap-tab.is-active .icap-tab__count {
        background: #1a4574;
        color: #fff;
    }
    .icap-card {
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        background: #fff;
        box-shadow: 0 1px 3px rgba(15,39,68,.06);
    }
    .icap-field-label {
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #64748b;
        margin-bottom: .25rem;
    }
    .icap-field-value {
        white-space: pre-wrap;
        color: #1e293b;
    }
</style>
@endsection

@section('content')
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="icapModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="icapModalLabel">Registrar expediente disciplinario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-add" enctype="multipart/form-data">
                    <div class="alert alert-info p-2 border mb-3">
                        <p class="mb-0 text-muted">Complete los campos del registro ICAP.</p>
                    </div>

                    <div id="fields-expediente">
                        <div class="form-group">
                            <label class="form-label" for="causa">Causa</label>
                            <textarea class="form-control" id="causa" name="causa" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="resulta_exp">Resulta</label>
                            <textarea class="form-control" id="resulta_exp" name="resulta" rows="4"></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label" for="culminacion_proceso_exp">Culminación del proceso</label>
                            <textarea class="form-control" id="culminacion_proceso_exp" name="culminacion_proceso" rows="4"></textarea>
                        </div>
                    </div>

                    <div id="fields-sobreviviente" style="display:none;">
                        <div class="form-group">
                            <label class="form-label" for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="resulta_sob">Resulta</label>
                            <textarea class="form-control" id="resulta_sob" name="resulta" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="culminacion_proceso_sob">Culminación del proceso</label>
                            <textarea class="form-control" id="culminacion_proceso_sob" name="culminacion_proceso" rows="4"></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label" for="copia_digitalizada">Copia digitalizada</label>
                            <input type="file" class="form-control-file" id="copia_digitalizada" name="copia_digitalizada" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted">JPG, PNG o PDF. Máximo 5 MB.</small>
                            <div id="copia-preview" class="mt-2" style="display:none;"></div>
                        </div>
                    </div>

                    <hr>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                            <i class="fas fa-check-circle"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="au-breadcrumb-content">
            <div class="au-breadcrumb-left">
                <a href="{{ route('officers') }}" class="btn text-uppercase text-dark"><i class="fas fa-arrow-left"></i> Regresar</a>
            </div>
            <a class="btn btn-dark btn-lg" href="#" id="btn-add">
                <i class="zmdi zmdi-plus"></i> <span id="btn-add-label">Agregar expediente</span>
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <h2>{{ $title }}</h2>
    <hr>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50/80 px-2 pt-2" role="tablist">
            <div class="flex flex-wrap gap-1">
                <button type="button" class="icap-tab is-active" data-tab="expedientes">
                    Expedientes Disciplinarios <span class="icap-tab__count" id="count-expedientes">0</span>
                </button>
                <button type="button" class="icap-tab" data-tab="sobreviviente">
                    Sobreviviente <span class="icap-tab__count" id="count-sobreviviente">0</span>
                </button>
            </div>
        </div>
        <div class="p-3">
            <div id="icap-container"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var id = '';
    var currentTab = 'expedientes';
    var apiBase = @json(url('api'));
    var expedientes = [];
    var sobrevivientes = [];

    loadAll();

    $(document).on('cpet:refresh-table', loadAll);

    function apiPath() {
        return currentTab === 'expedientes' ? '/officers/icap/expedientes' : '/officers/icap/sobreviviente';
    }

    function modalTitle() {
        return currentTab === 'expedientes' ? 'expediente disciplinario' : 'registro de sobreviviente';
    }

    function syncModalFields() {
        const isExp = currentTab === 'expedientes';
        $('#fields-expediente').toggle(isExp);
        $('#fields-sobreviviente').toggle(!isExp);
        $('#btn-add-label').text(isExp ? 'Agregar expediente' : 'Agregar registro');
        $('#icapModalLabel').text('Registrar ' + modalTitle());
    }

    document.querySelectorAll('.icap-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.icap-tab').forEach(t => t.classList.remove('is-active'));
            tab.classList.add('is-active');
            currentTab = tab.getAttribute('data-tab');
            syncModalFields();
            renderList();
        });
    });

    function renderCopiaPreview(url, isPdf) {
        if (!url) {
            $('#copia-preview').hide().html('');
            return;
        }
        const html = isPdf
            ? '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="fas fa-file-pdf"></i> Ver PDF</a>'
            : '<a href="' + url + '" target="_blank"><img src="' + url + '" alt="Copia" class="img-thumbnail" style="max-height:160px;"></a>';
        $('#copia-preview').html(html).show();
    }

    function isPdfPath(path) {
        return /\.pdf$/i.test(path || '');
    }

    $('#copia_digitalizada').on('change', function () {
        const file = this.files[0];
        if (!file) return;
        renderCopiaPreview(URL.createObjectURL(file), file.type === 'application/pdf');
    });

    $('#btn-add').click(function (e) {
        e.preventDefault();
        $('#form-edit').attr('id', 'form-add');
        $('#form-add').trigger('reset');
        renderCopiaPreview(null);
        syncModalFields();
        $('#btn-submit').text('Guardar').attr('class', 'btn btn-primary btn-lg');
        $('#add').modal('show');
    });

    function buildFormData(form) {
        const formData = new FormData(form);
        formData.append('id_policia', '{{ $id }}');

        if (currentTab === 'expedientes') {
            formData.set('resulta', $('#resulta_exp').val() || '');
            formData.set('culminacion_proceso', $('#culminacion_proceso_exp').val() || '');
            formData.delete('observaciones');
            formData.delete('copia_digitalizada');
        } else {
            formData.set('resulta', $('#resulta_sob').val() || '');
            formData.set('culminacion_proceso', $('#culminacion_proceso_sob').val() || '');
            formData.delete('causa');
        }

        return formData;
    }

    $(document).on('submit', '#form-add', function (e) {
        e.preventDefault();
        fetch(apiBase + apiPath(), { method: 'POST', body: buildFormData(this) })
            .then(async r => {
                const data = await r.json();
                if (!r.ok) throw data;
                return data;
            })
            .then(data => {
                CpetModule.afterSave({ message: data.msj, refresh: loadAll });
            })
            .catch(err => {
                const msg = err?.message || 'Error al guardar';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            });
    });

    $(document).on('submit', '#form-edit', function (e) {
        e.preventDefault();
        const formData = buildFormData(this);
        formData.append('_method', 'PUT');
        fetch(apiBase + apiPath() + '/' + id, { method: 'POST', body: formData })
            .then(async r => {
                const data = await r.json();
                if (!r.ok) throw data;
                return data;
            })
            .then(data => {
                CpetModule.afterSave({
                    message: data.msj,
                    refresh: loadAll,
                    onReset: function () {
                        $('#form-edit').trigger('reset').attr('id', 'form-add');
                        id = '';
                    }
                });
            })
            .catch(err => {
                Swal.fire({ icon: 'error', title: 'Error', text: err?.message || 'Error al actualizar' });
            });
    });

    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        fetch(apiBase + apiPath() + '/' + id)
            .then(r => r.json())
            .then(data => {
                id = data.id;
                if (currentTab === 'expedientes') {
                    $('#causa').val(data.causa || '');
                    $('#resulta_exp').val(data.resulta || '');
                    $('#culminacion_proceso_exp').val(data.culminacion_proceso || '');
                } else {
                    $('#observaciones').val(data.observaciones || '');
                    $('#resulta_sob').val(data.resulta || '');
                    $('#culminacion_proceso_sob').val(data.culminacion_proceso || '');
                    if (data.copia_digitalizada_url) {
                        renderCopiaPreview(data.copia_digitalizada_url, isPdfPath(data.copia_digitalizada));
                    } else {
                        renderCopiaPreview(null);
                    }
                }
                syncModalFields();
                $('#form-add').attr('id', 'form-edit');
                $('#btn-submit').attr('class', 'btn btn-dark btn-lg').text('Actualizar');
                $('#icapModalLabel').text('Editar ' + modalTitle());
                $('#add').modal('show');
            });
    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esto.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            fetch(apiBase + apiPath() + '/' + id, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    CpetModule.afterSave({ message: data.msj, refresh: loadAll });
                });
        });
    });

    function fieldBlock(label, value) {
        const text = value && String(value).trim() ? value : 'Sin información';
        return `<div class="mb-3"><div class="icap-field-label">${label}</div><div class="icap-field-value">${text}</div></div>`;
    }

    function renderList() {
        const data = currentTab === 'expedientes' ? expedientes : sobrevivientes;
        let html = '';

        if (!data.length) {
            html = `<div class="text-center text-muted py-5">No hay registros en esta pestaña</div>`;
        } else if (currentTab === 'expedientes') {
            data.forEach(e => {
                html += `
                <div class="icap-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-0 font-weight-bold">Expediente #${e.id}</h5>
                        <div>
                            <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    ${fieldBlock('Causa', e.causa)}
                    ${fieldBlock('Resulta', e.resulta)}
                    ${fieldBlock('Culminación del proceso', e.culminacion_proceso)}
                </div>`;
            });
        } else {
            data.forEach(e => {
                const copia = e.copia_digitalizada_url
                    ? (isPdfPath(e.copia_digitalizada)
                        ? `<a href="${e.copia_digitalizada_url}" target="_blank" class="btn btn-sm btn-outline-dark mt-1"><i class="fas fa-file-pdf"></i> Ver copia digitalizada</a>`
                        : `<a href="${e.copia_digitalizada_url}" target="_blank"><img src="${e.copia_digitalizada_url}" alt="Copia" class="img-thumbnail mt-1" style="max-height:140px;"></a>`)
                    : '<span class="text-muted">Sin archivo</span>';
                html += `
                <div class="icap-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-0 font-weight-bold">Registro #${e.id}</h5>
                        <div>
                            <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    ${fieldBlock('Observaciones', e.observaciones)}
                    ${fieldBlock('Resulta', e.resulta)}
                    ${fieldBlock('Culminación del proceso', e.culminacion_proceso)}
                    <div class="mb-0"><div class="icap-field-label">Copia digitalizada</div>${copia}</div>
                </div>`;
            });
        }

        $('#icap-container').html(html);
    }

    function loadAll() {
        Promise.all([
            fetch(apiBase + '/officers/icap/expedientes/index/{{ $id }}').then(r => r.json()),
            fetch(apiBase + '/officers/icap/sobreviviente/index/{{ $id }}').then(r => r.json())
        ]).then(([exp, sob]) => {
            expedientes = exp || [];
            sobrevivientes = sob || [];
            $('#count-expedientes').text(expedientes.length);
            $('#count-sobreviviente').text(sobrevivientes.length);
            renderList();
        });
    }

    syncModalFields();
});
</script>
@endsection
