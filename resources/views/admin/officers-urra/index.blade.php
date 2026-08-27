@extends('layouts.app')

@section('content')
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="urraModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="urraModalLabel">Registro URRA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-add">
                    <div class="alert alert-info p-2 border mb-3">
                        <p class="mb-0 text-muted">Los campos marcados con (*) son obligatorios. Si la fecha de culminación es posterior a hoy, se marcará automáticamente «en servicio».</p>
                    </div>
                    <div class="card">
                        <div class="card-header">Datos de la asignación</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="fecha_inicio">Día de inicio *</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="fecha_culminacion">Día de culminación</label>
                                    <input type="date" class="form-control" id="fecha_culminacion" name="fecha_culminacion">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="tiempo_servicio">Tiempo de servicio</label>
                                    <input type="text" class="form-control" id="tiempo_servicio" name="tiempo_servicio"
                                           placeholder="Se calcula automáticamente si lo deja vacío">
                                    <small class="text-muted">Ejemplo: 3 meses y 12 días</small>
                                </div>
                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="en_servicio" name="en_servicio" value="1">
                                        <label class="form-check-label" for="en_servicio">Actualmente en servicio</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="observaciones">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
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
                <i class="zmdi zmdi-plus"></i> Agregar URRA
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <h2>{{ $title }}</h2>
    <hr>

    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <p class="h5 mb-1"><i class="fas fa-user-check text-success"></i> <b>En servicio:</b> <span id="urra-en-servicio">0</span></p>
            <p class="h5 mb-0"><i class="fas fa-flag-checkered text-secondary"></i> <b>Finalizados:</b> <span id="urra-finalizados">0</span></p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="urra-table" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Culminación</th>
                    <th class="text-center">Tiempo de servicio</th>
                    <th class="text-center">En servicio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var id = '';
    var apiBase = @json(url('api'));
    var reportBase = @json(url('reports/urra/ficha'));

    var dtEs = {
        decimal: ',', thousands: '.', processing: 'Procesando...', search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        loadingRecords: 'Cargando...', zeroRecords: 'No se encontraron resultados',
        emptyTable: 'No hay registros URRA',
        paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Último' }
    };

    index();
    $(document).on('cpet:refresh-table', index);
    bindAutoEnServicio();

    $('#btn-add').click(function (e) {
        e.preventDefault();
        $('#form-edit').attr('id', 'form-add');
        $('#form-add').trigger('reset');
        $('#en_servicio').prop('checked', false);
        $('#btn-submit').html('<i class="fas fa-check-circle"></i> Guardar').attr('class', 'btn btn-primary btn-lg');
        $('#add').modal('show');
    });

    $(document).on('submit', '#form-add', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('id_policia', '{{ $id }}');
        if (!$('#en_servicio').is(':checked')) formData.set('en_servicio', '0');
        fetch(apiBase + '/officers/urra', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                CpetModule.afterSave({ message: data.msj || 'Guardado', refresh: index });
            });
    });

    $(document).on('submit', '#form-edit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');
        if (!$('#en_servicio').is(':checked')) formData.set('en_servicio', '0');
        fetch(apiBase + '/officers/urra/' + id, { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                CpetModule.afterSave({
                    message: data.msj || 'Actualizado',
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
        fetch(apiBase + '/officers/urra/' + id)
            .then(r => r.json())
            .then(data => {
                id = data.id;
                $('#fecha_inicio').val(data.fecha_inicio ? String(data.fecha_inicio).substr(0, 10) : '');
                $('#fecha_culminacion').val(data.fecha_culminacion ? String(data.fecha_culminacion).substr(0, 10) : '');
                $('#tiempo_servicio').val(data.tiempo_servicio || '');
                $('#observaciones').val(data.observaciones || '');
                $('#en_servicio').prop('checked', !!data.en_servicio);
                $('#form-add').attr('id', 'form-edit');
                $('#btn-submit').attr('class', 'btn btn-dark btn-lg').html('<i class="fas fa-save"></i> Actualizar');
                $('#add').modal('show');
            });
    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        var formData = new FormData();
        formData.append('_method', 'DELETE');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esto.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            fetch(apiBase + '/officers/urra/' + id, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    CpetModule.afterSave({ message: data.msj || 'Eliminado', refresh: index });
                });
        });
    });

    function bindAutoEnServicio() {
        $('#fecha_culminacion').on('change', function () {
            var fin = $(this).val();
            if (!fin) return;
            var hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            var dFin = new Date(fin + 'T00:00:00');
            if (dFin > hoy) {
                $('#en_servicio').prop('checked', true);
            } else {
                $('#en_servicio').prop('checked', false);
            }
        });
    }

    function index() {
        fetch(apiBase + '/officers/urra/index/{{ $id }}')
            .then(r => r.json())
            .then(function (payload) {
                var rows = Array.isArray(payload) ? payload : (payload.data || []);
                var counts = payload.counts || {
                    en_servicio: rows.filter(r => r.en_servicio).length,
                    finalizados: rows.filter(r => !r.en_servicio).length,
                    total: rows.length
                };

                $('#urra-en-servicio').text(counts.en_servicio);
                $('#urra-finalizados').text(counts.finalizados);

                var template = '';
                rows.forEach(function (e) {
                    var inicio = e.fecha_inicio ? String(e.fecha_inicio).substr(0, 10) : 'S/F';
                    var fin = e.fecha_culminacion ? String(e.fecha_culminacion).substr(0, 10) : 'S/F';
                    template += `
                        <tr>
                            <td class="text-center">${inicio}</td>
                            <td class="text-center">${fin}</td>
                            <td class="text-center">${e.tiempo_servicio || '—'}</td>
                            <td class="text-center">${e.en_servicio ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>'}</td>
                            <td class="text-right">
                                <a href="${reportBase}/${e.id}" target="_blank" class="btn btn-dark btn-sm" title="Ficha URRA"><i class="fas fa-print"></i></a>
                                <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="far fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>`;
                });

                CpetModule.refreshDataTable('#urra-table', template || '<tr><td colspan="5" class="text-center text-muted">Sin registros</td></tr>', {
                    order: [[0, 'desc']],
                    columnDefs: [{ orderable: false, targets: 4 }]
                });
            });
    }
});
</script>
@endsection
