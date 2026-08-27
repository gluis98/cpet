@extends('layouts.app')

@section('content')
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="catalogModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="catalogModalLabel">Registrar {{ $singular }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-add">
                    <div class="alert alert-info p-2 border mb-3">
                        <p class="mb-0 text-muted">Los campos marcados con (*) son obligatorios.</p>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label" for="nombre">Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                               placeholder="{{ $placeholder }}">
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

<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">Configuraciones</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
    </div>
    <button type="button" class="btn btn-primary" id="btn-add">
        <i class="fas fa-plus"></i> Agregar {{ $singular }}
    </button>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="catalog-table" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width:70px">#</th>
                        <th>Nombre</th>
                        <th class="text-right" style="width:120px"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    var id = '';
    var apiBase = @json(url('api'));
    var endpoint = @json($apiEndpoint);
    var singular = @json($singular);

    var dtEs = {
        decimal: ',', thousands: '.', processing: 'Procesando...', search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        loadingRecords: 'Cargando...', zeroRecords: 'No se encontraron resultados',
        emptyTable: 'No hay registros',
        paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Último' }
    };

    index();

    $(document).on('cpet:refresh-table', index);

    $('#btn-add').on('click', function (e) {
        e.preventDefault();
        $('#form-edit').attr('id', 'form-add');
        $('#form-add').trigger('reset');
        $('#catalogModalLabel').text('Registrar ' + singular);
        $('#btn-submit').text('Guardar').attr('class', 'btn btn-primary btn-lg');
        id = '';
        $('#add').modal('show');
    });

    function handleError(err) {
        var msg = err?.msj || err?.message || (err?.errors ? Object.values(err.errors).flat().join('\n') : 'Error al procesar');
        Swal.fire({ icon: 'error', title: 'No se pudo completar', text: msg });
    }

    $(document).on('submit', '#form-add', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch(apiBase + endpoint, { method: 'POST', body: formData, headers: { Accept: 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(async function (r) {
                var data = await r.json();
                if (!r.ok) throw data;
                return data;
            })
                .then(function (data) {
                    CpetModule.afterSave({ message: data.msj || 'Guardado', refresh: index });
                })
            .catch(handleError);
    });

    $(document).on('submit', '#form-edit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');
        fetch(apiBase + endpoint + '/' + id, { method: 'POST', body: formData, headers: { Accept: 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(async function (r) {
                var data = await r.json();
                if (!r.ok) throw data;
                return data;
            })
                .then(function (data) {
                    CpetModule.afterSave({
                        message: data.msj || 'Actualizado',
                        refresh: index,
                        onReset: function () {
                            $('#form-edit').attr('id', 'form-add');
                            id = '';
                        }
                    });
                })
            .catch(handleError);
    });

    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        fetch(apiBase + endpoint + '/' + id)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                $('#nombre').val(data.nombre || '');
                $('#form-add').attr('id', 'form-edit');
                $('#catalogModalLabel').text('Editar ' + singular);
                $('#btn-submit').text('Actualizar').attr('class', 'btn btn-dark btn-lg');
                $('#add').modal('show');
            });
    });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar este registro?',
            text: 'No podrás revertir esto.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            var formData = new FormData();
            formData.append('_method', 'DELETE');
            fetch(apiBase + endpoint + '/' + id, {
                method: 'POST',
                body: formData,
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
                .then(async function (r) {
                    var data = await r.json();
                    if (!r.ok) throw data;
                    return data;
                })
                .then(function (data) {
                    CpetModule.afterSave({ message: data.msj || 'Eliminado', refresh: index });
                })
                .catch(handleError);
        });
    });

    function index() {
        fetch(apiBase + endpoint)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var rows = '';
                (data || []).forEach(function (e, i) {
                    rows += `
                    <tr>
                        <td class="text-center">${i + 1}</td>
                        <td>${e.nombre}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
                if ($.fn.DataTable.isDataTable('#catalog-table')) {
                    CpetModule.destroyTable('#catalog-table');
                }
                $('#catalog-table tbody').html(rows || '<tr><td colspan="3" class="text-center text-muted">Sin registros</td></tr>');
                $('#catalog-table').DataTable({ language: CpetModule.dtEs, pageLength: 25, order: [[1, 'asc']] });
            });
    }
});
</script>
@endsection
