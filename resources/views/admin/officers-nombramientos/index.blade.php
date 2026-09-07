@extends('layouts.app')

@section('content')
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar nombramiento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add">
                <div class="alert alert-info p-2 border mb-3">
                    <p class="mb-0 text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">Datos del nombramiento</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="id_tipo_nombramiento">De qué fue nombrado *</label>
                                <div class="input-group">
                                    <select class="form-control" id="id_tipo_nombramiento" name="id_tipo_nombramiento" required>
                                        <option value="">--- SELECCIONE ---</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="btn-add-tipo" title="Agregar tipo de nombramiento">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Si no aparece en la lista, pulsa + para agregarlo.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="id_estacion">Estación *</label>
                                <select class="form-control" id="id_estacion" name="id_estacion" required>
                                    <option value="">--- CARGANDO ESTACIONES ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="fecha_inicio">Fecha inicio *</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="fecha_final">Fecha final</label>
                                <input type="date" class="form-control" id="fecha_final" name="fecha_final">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="is_actual" name="is_actual" value="1">
                                <label class="form-check-label" for="is_actual">
                                    ¿Nombramiento actual?
                                </label>
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
                <i class="zmdi zmdi-plus"></i> Agregar nombramiento
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <h2>{{ $title }}</h2>
    <hr>
    <div class="row" id="nombramientos-container"></div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var id = '';
    var apiBase = @json(url('api'));
    var reportBase = @json(url('reports/nombramiento'));

    index();
    indexEstaciones();
    indexTipos();

    $(document).on('cpet:refresh-table', index);

    $('#btn-add-tipo').on('click', function () {
        CpetCatalog.promptAdd({
            title: 'Nuevo tipo de nombramiento',
            placeholder: 'Ejemplo: Director, Jefe de División…',
            postUrl: apiBase + '/catalogo-nombramientos',
            $select: $('#id_tipo_nombramiento'),
            successMessage: 'Tipo de nombramiento agregado',
        });
    });

    $('#btn-add').on('click', function (e) {
        e.preventDefault();
        $('#form-edit').attr('id', 'form-add');
        $('#form-add').trigger('reset');
        indexTipos();
        indexEstaciones();
        $('#btn-submit').text('Guardar').attr('class', 'btn btn-primary btn-lg');
        $('#add').modal('show');
    });

    $(document).on('submit', '#form-add', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('id_policia', '{{ $id }}');
        fetch(apiBase + '/officers/nombramientos', {
            method: 'POST',
            body: formData
        }).then(function (r) { return r.json(); })
        .then(function (data) {
            CpetModule.afterSave({ message: data.msj, refresh: index });
        });
    });

    $(document).on('submit', '#form-edit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');
        fetch(apiBase + '/officers/nombramientos/' + id, {
            method: 'POST',
            body: formData
        }).then(function (r) { return r.json(); })
        .then(function (data) {
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
        fetch(apiBase + '/officers/nombramientos/' + id)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                id = data.id;
                Promise.all([
                    indexTipos(data.id_tipo_nombramiento),
                    indexEstaciones(data.id_estacion)
                ]).then(function () {
                    $('#is_actual').prop('checked', data.is_actual == 1);
                    $('#fecha_inicio').val(data.fecha_inicio ? String(data.fecha_inicio).substr(0, 10) : '');
                    $('#fecha_final').val(data.fecha_final ? String(data.fecha_final).substr(0, 10) : '');
                    $('#descripcion').val(data.descripcion || '');
                    $('#form-add').attr('id', 'form-edit');
                    $('#btn-submit').attr('class', 'btn btn-dark btn-lg').text('Actualizar');
                    $('#add').modal('show');
                });
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
            fetch(apiBase + '/officers/nombramientos/' + id, {
                method: 'POST',
                body: formData
            }).then(function (r) { return r.json(); })
            .then(function (data) {
                CpetModule.afterSave({ message: data.msj, refresh: index });
            });
        });
    });

    function formatMonthYear(value) {
        if (!value) return 'Sin fecha';
        return new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(new Date(value));
    }

    function index() {
        fetch(apiBase + '/officers/nombramientos/index/{{ $id }}')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var template = '';
                if (!data.length) {
                    template = `
                        <div class="col-12">
                            <div class="border p-3">
                                <h5 class="text-center text-muted mb-0">No hay datos registrados</h5>
                            </div>
                        </div>`;
                } else {
                    data.forEach(function (e) {
                        var tipo = (e.tipo_nombramiento && e.tipo_nombramiento.nombre) ? e.tipo_nombramiento.nombre : 'Sin tipo';
                        var estacion = (e.estacione && e.estacione.estacion) ? e.estacione.estacion : 'Sin estación';
                        template += `
                        <div class="col-md-4">
                            <div class="card mb-3 shadow">
                                <div class="card-header h4">
                                    <i class="fas fa-user-tie"></i> ${tipo}
                                </div>
                                <div class="card-body">
                                    <p><strong>Estación:</strong><br>${estacion}</p>
                                    <p><strong>Estado:</strong><br>${e.is_actual == 1 ? '<i class="fas fa-medal text-warning"></i> Nombramiento actual' : 'Histórico'}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Inicio:</strong><br>${formatMonthYear(e.fecha_inicio)}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Final:</strong><br>${formatMonthYear(e.fecha_final)}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="text-justify">${e.descripcion || 'Sin descripción'}</p>
                                    <hr>
                                    <div class="text-right">
                                        <a href="${reportBase}/${e.id}" target="_blank" class="btn btn-dark btn-sm" title="Imprimir nombramiento"><i class="fas fa-print"></i></a>
                                        <button class="btn btn-dark btn-sm edit" data-id="${e.id}" title="Editar"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete" data-id="${e.id}" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });
                }
                $('#nombramientos-container').html(template);
            });
    }

    function indexEstaciones(selectedId) {
        return fetch(apiBase + '/stations')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var template = '<option value="">--- SELECCIONE UNA ESTACIÓN ---</option>';
                (data || []).forEach(function (e) {
                    template += `<option value="${e.id}">${e.estacion}</option>`;
                });
                $('#id_estacion').html(template);
                if (selectedId) {
                    $('#id_estacion').val(String(selectedId));
                }
            });
    }

    function indexTipos(selectedId) {
        return CpetCatalog.loadSelect(
            $('#id_tipo_nombramiento'),
            apiBase + '/catalogo-nombramientos',
            selectedId,
            '--- SELECCIONE ---'
        );
    }
});
</script>
@endsection
