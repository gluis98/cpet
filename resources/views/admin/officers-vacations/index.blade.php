@extends('layouts.app')

@section('styles')
<style>
    .vac-tab {
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
    .vac-tab:hover { color: #1a4574; background: rgba(255,255,255,.7); }
    .vac-tab.is-active {
        color: #0f2744;
        background: #fff;
        position: relative;
    }
    .vac-tab.is-active::after {
        content: "";
        position: absolute;
        left: .75rem; right: .75rem; bottom: 0;
        height: 3px; border-radius: 999px;
        background: linear-gradient(90deg, #c4922e, #d4a84b);
    }
    .vac-tab__count {
        min-width: 1.35rem;
        border-radius: 999px;
        padding: .1rem .45rem;
        font-size: .7rem;
        font-weight: 700;
        background: #e2e8f0;
        color: #475569;
    }
    .vac-tab.is-active .vac-tab__count {
        background: #1a4574;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Solicitud de vacaciones</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add">
                <div class="alert alert-info p-2 border mb-3">
                    <p class="mb-0 text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">Datos de la solicitud</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="estatus">Estatus *</label>
                                <select class="form-control" id="estatus" name="estatus" required>
                                    <option value="">--- SELECCIONE UN ESTATUS ---</option>
                                    <option value="APROBADAS">APROBADAS</option>
                                    <option value="NEGADAS">NEGADAS</option>
                                    <option value="VENCIDAS">VENCIDAS</option>
                                    <option value="REGLAMENTARIAS">REGLAMENTARIAS</option>
                                    <option value="EN PROCESO">EN PROCESO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="fecha_emision">Fecha de emisión / Desde *</label>
                                <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="fecha_hasta">Hasta</label>
                                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="fecha_reintegro">Fecha de reintegro</label>
                                <input type="date" class="form-control" id="fecha_reintegro" name="fecha_reintegro">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_disfrutadas" name="is_disfrutadas" value="1">
                                    <label class="form-check-label" for="is_disfrutadas">¿Vacaciones disfrutadas?</label>
                                </div>
                                <small class="text-muted">Si la fecha de reintegro ya pasó, se marcarán automáticamente como disfrutadas.</small>
                            </div>
                        </div>
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
                <i class="zmdi zmdi-plus"></i> Agregar solicitud de vacaciones
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <h2>{{ $title }}</h2>
    <hr>

    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <p class="h5 mb-1"><i class="fas fa-check text-success"></i> <b>Disfrutadas:</b> <span id="vacaciones-disfrutadas">0</span></p>
            <p class="h5 mb-1"><i class="fas fa-spinner text-primary"></i> <b>En proceso:</b> <span id="vacaciones-proceso">0</span></p>
            <p class="h5 mb-0"><i class="fas fa-times text-danger"></i> <b>Vencidas:</b> <span id="vacaciones-vencidas">0</span></p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50/80 px-2 pt-2" role="tablist">
            <div class="flex flex-wrap gap-1">
                <button type="button" class="vac-tab is-active" data-tab="todas">
                    Todas <span class="vac-tab__count" id="count-todas">0</span>
                </button>
                <button type="button" class="vac-tab" data-tab="disfrutadas">
                    Disfrutadas <span class="vac-tab__count" id="count-disfrutadas">0</span>
                </button>
                <button type="button" class="vac-tab" data-tab="proceso">
                    En proceso <span class="vac-tab__count" id="count-proceso">0</span>
                </button>
                <button type="button" class="vac-tab" data-tab="vencidas">
                    Vencidas <span class="vac-tab__count" id="count-vencidas">0</span>
                </button>
            </div>
        </div>

        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="vacaciones-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Fecha de emisión</th>
                            <th class="text-center">Hasta</th>
                            <th class="text-center">Fecha de reintegro</th>
                            <th class="text-center">¿Disfrutadas?</th>
                            <th class="text-center">Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var id = '';
    var currentTab = 'todas';
    var allRows = [];
    var apiBase = @json(url('api'));
    var reportBase = @json(url('reports/vacation'));

    var dtEs = {
        decimal: ',', thousands: '.', processing: 'Procesando...', search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        loadingRecords: 'Cargando...', zeroRecords: 'No se encontraron resultados',
        emptyTable: 'No hay vacaciones en esta pestaña',
        paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Último' }
    };

    index();
    $(document).on('cpet:refresh-table', index);
    toggleCheckbox();
    $('#estatus').on('change', toggleCheckbox);

    document.querySelectorAll('.vac-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.vac-tab').forEach(t => t.classList.remove('is-active'));
            tab.classList.add('is-active');
            currentTab = tab.getAttribute('data-tab');
            renderTable();
        });
    });

    $('#btn-add').click(function (e) {
        e.preventDefault();
        $('#form-edit').attr('id', 'form-add');
        $('#form-add').trigger('reset');
        $('#estatus option').prop('selected', false);
        $('#is_disfrutadas').prop('checked', false);
        toggleCheckbox();
        $('#btn-submit').text('Guardar').attr('class', 'btn btn-primary btn-lg');
        $('#add').modal('show');
    });

    $(document).on('submit', '#form-add', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('id_policia', '{{ $id }}');
        if (!$('#is_disfrutadas').is(':checked')) formData.set('is_disfrutadas', '0');
        fetch(apiBase + '/officers/vacations', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                CpetModule.afterSave({ message: data.msj, refresh: index });
            });
    });

    $(document).on('submit', '#form-edit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_method', 'PUT');
        if (!$('#is_disfrutadas').is(':checked')) formData.set('is_disfrutadas', '0');
        fetch(apiBase + '/officers/vacations/' + id, { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                CpetModule.afterSave({
                    message: data.msj,
                    refresh: index,
                    onReset: function () {
                        $('#form-edit').trigger('reset').attr('id', 'form-add');
                        id = '';
                    }
                });
            });
    });

    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        fetch(apiBase + '/officers/vacations/' + id)
            .then(r => r.json())
            .then(data => {
                id = data.id;
                $('#fecha_emision').val(data.fecha_emision ? String(data.fecha_emision).substr(0, 10) : '');
                $('#fecha_hasta').val(data.fecha_hasta ? String(data.fecha_hasta).substr(0, 10) : '');
                $('#fecha_reintegro').val(data.fecha_reintegro ? String(data.fecha_reintegro).substr(0, 10) : '');
                $('#descripcion').val(data.descripcion || '');
                $('#estatus').val(data.estatus || '');
                $('#is_disfrutadas').prop('checked', data.is_disfrutadas == 1);
                toggleCheckbox();
                $('#form-add').attr('id', 'form-edit');
                $('#btn-submit').attr('class', 'btn btn-dark btn-lg').text('Actualizar');
                $('#add').modal('show');
            });
    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        let formData = new FormData();
        formData.append('_method', 'DELETE');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esto.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;
            fetch(apiBase + '/officers/vacations/' + id, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    CpetModule.afterSave({ message: data.msj, refresh: index });
                });
        });
    });

    function isVencida(e) {
        return String(e.estatus || '').toUpperCase() === 'VENCIDAS';
    }

    function isDisfrutada(e) {
        return e.is_disfrutadas == 1 || e.is_disfrutadas === true;
    }

    function isEnProceso(e) {
        if (isDisfrutada(e) || isVencida(e)) return false;
        var st = String(e.estatus || '').toUpperCase();
        return st !== 'NEGADAS';
    }

    function filterRows() {
        if (currentTab === 'disfrutadas') return allRows.filter(isDisfrutada);
        if (currentTab === 'proceso') return allRows.filter(isEnProceso);
        if (currentTab === 'vencidas') return allRows.filter(isVencida);
        return allRows;
    }

    function renderTable() {
        var rows = filterRows();
        var template = '';
        rows.forEach(function (e) {
            var emision = e.fecha_emision ? String(e.fecha_emision).substr(0, 10) : 'S/F';
            var hasta = e.fecha_hasta ? String(e.fecha_hasta).substr(0, 10) : 'S/F';
            var reintegro = e.fecha_reintegro ? String(e.fecha_reintegro).substr(0, 10) : 'S/F';
            template += `
                <tr>
                    <td class="text-center">${emision}</td>
                    <td class="text-center">${hasta}</td>
                    <td class="text-center">${reintegro}</td>
                    <td class="text-center">${isDisfrutada(e) ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>'}</td>
                    <td class="text-center">${e.estatus || ''}</td>
                    <td class="text-right">
                        <a href="${reportBase}/${e.id}" target="_blank" class="btn btn-dark btn-sm"><i class="fas fa-print"></i></a>
                        <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="far fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>`;
        });

        CpetModule.refreshDataTable('#vacaciones-table', template || '<tr><td colspan="6" class="text-center text-muted">Sin registros</td></tr>', {
            order: [[0, 'desc']],
            columnDefs: [{ orderable: false, targets: 5 }]
        });
    }

    function index() {
        fetch(apiBase + '/officers/vacations/index/{{ $id }}')
            .then(r => r.json())
            .then(payload => {
                // Compatibilidad: array plano o { data, counts }
                allRows = Array.isArray(payload) ? payload : (payload.data || []);
                var counts = payload.counts || {
                    disfrutadas: allRows.filter(isDisfrutada).length,
                    en_proceso: allRows.filter(isEnProceso).length,
                    vencidas: allRows.filter(isVencida).length,
                    total: allRows.length
                };

                $('#vacaciones-disfrutadas').text(counts.disfrutadas);
                $('#vacaciones-proceso').text(counts.en_proceso);
                $('#vacaciones-vencidas').text(counts.vencidas);
                $('#count-todas').text(counts.total);
                $('#count-disfrutadas').text(counts.disfrutadas);
                $('#count-proceso').text(counts.en_proceso);
                $('#count-vencidas').text(counts.vencidas);

                renderTable();
            });
    }

    function toggleCheckbox() {
        const status = $('#estatus').val();
        if (status === 'APROBADAS' || status === 'EN PROCESO' || status === 'REGLAMENTARIAS') {
            $('#is_disfrutadas').prop('disabled', false);
        } else {
            $('#is_disfrutadas').prop('disabled', true).prop('checked', false);
        }
    }
});
</script>
@endsection
