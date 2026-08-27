@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.min.css') }}">
<style>
    #officers-table, #officers-table_wrapper, .dataTables_wrapper, table.dataTable {
        width: 100% !important;
    }

    .estatus-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.65rem 0.95rem;
        border: 0;
        border-radius: 0.75rem 0.75rem 0 0;
        background: transparent;
        color: #64748b;
        font-family: inherit;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        transition: color 0.15s, background 0.15s, box-shadow 0.15s;
        white-space: nowrap;
    }

    .estatus-tab:hover {
        color: #1a4574;
        background: rgba(255, 255, 255, 0.75);
    }

    .estatus-tab.is-active {
        color: #0f2744;
        background: #fff;
        box-shadow: 0 -1px 0 #fff, 0 1px 0 #fff;
        position: relative;
    }

    .estatus-tab.is-active::after {
        content: "";
        position: absolute;
        left: 0.65rem;
        right: 0.65rem;
        bottom: 0;
        height: 3px;
        border-radius: 999px;
        background: linear-gradient(90deg, #c4922e, #d4a84b);
    }

    .estatus-tab__count {
        display: inline-flex;
        min-width: 1.35rem;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0.1rem 0.45rem;
        font-size: 0.7rem;
        font-weight: 700;
        background: #e2e8f0;
        color: #475569;
    }

    .estatus-tab.is-active .estatus-tab__count {
        background: #1a4574;
        color: #fff;
    }

    .estatus-tabs-wrap {
        overflow-x: auto;
        scrollbar-width: thin;
    }

    /* El menú de submódulos debe poder salir del contenedor de la tabla */
    .officers-table-panel,
    .officers-table-panel .dataTables_wrapper,
    .officers-table-panel .dataTables_scroll,
    .officers-table-panel .dataTables_scrollBody,
    .officers-table-panel .table-responsive {
        overflow: visible !important;
    }

    .officers-table-panel td.actions {
        overflow: visible !important;
        position: relative;
    }

    .officers-table-panel .dropdown-menu {
        z-index: 1060;
        max-height: min(70vh, 28rem);
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="modal fade" id="modal-archivos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 1000px !important; margin-left: -100px !important">
            <div class="modal-header">
                <h5 class="modal-title">Archivos del oficial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <p class="mb-0"><i class="fas fa-info-circle"></i> Sube y previsualiza los archivos del funcionario.</p>
                </div>
                <form class="dropzone" id="myDropzone" method="POST"></form>
                <hr>
                <div class="row" id="archivos-index"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">Funcionarios</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            {{ $totalFuncionarios }} registrados · filtra por estatus
        </p>
    </div>
    <a class="btn btn-primary" href="{{ route('officers.form.create', $tipo) }}">
        <i class="fas fa-plus"></i> Nuevo {{ $tipoFuncionario }}
    </a>
</div>

<div class="officers-table-panel overflow-visible rounded-2xl border border-slate-200 bg-white shadow-md shadow-slate-200/50">
    <div class="estatus-tabs-wrap border-b border-slate-200 bg-slate-50/80 px-2 pt-2 sm:px-3" role="tablist">
        <div class="flex min-w-max gap-1">
            <button type="button" class="estatus-tab is-active" data-estatus="" role="tab" aria-selected="true">
                <i class="fas fa-layer-group text-xs"></i>
                <span>Todos</span>
                <span class="estatus-tab__count">{{ $totalFuncionarios }}</span>
            </button>
            @foreach ($estatusList as $estatus)
                @php $count = (int) ($estatusCounts[$estatus] ?? 0); @endphp
                <button type="button"
                        class="estatus-tab {{ $count === 0 ? 'opacity-60' : '' }}"
                        data-estatus="{{ $estatus }}"
                        role="tab"
                        aria-selected="false">
                    <span>{{ $estatus }}</span>
                    <span class="estatus-tab__count">{{ $count }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="p-4 sm:p-5">
        <table class="table table-bordered table-hover" id="officers-table" style="width:100%;">
            <thead>
                <tr>
                    <th class="text-center">N° Credencial</th>
                    <th class="text-center">N° de Cédula</th>
                    <th class="text-center">Nombre y apellido</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Fecha de ingreso</th>
                    <th class="text-center">Jerarquía</th>
                    <th class="text-center">Cargo</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center actions">Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/dropzone/dropzone.min.js') }}"></script>
<script>
    Dropzone.autoDiscover = false;
    let officersTable;
    let id = '';
    let currentEstatus = '';
    const tipoFuncionario = @json($tipoFuncionario);
    const tipoSlug = @json($tipo);

    const dtEs = {
        decimal: ',',
        thousands: '.',
        processing: 'Procesando...',
        search: 'Buscar:',
        lengthMenu: 'Mostrar _MENU_ registros',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        infoPostFix: '',
        loadingRecords: 'Cargando...',
        zeroRecords: 'No se encontraron resultados',
        emptyTable: 'No hay funcionarios con este estatus',
        paginate: {
            first: 'Primero',
            previous: 'Anterior',
            next: 'Siguiente',
            last: 'Último'
        },
        aria: {
            sortAscending: ': activar para ordenar la columna de manera ascendente',
            sortDescending: ': activar para ordenar la columna de manera descendente'
        }
    };

    $(document).ready(function () {
        $(document).on('cpet:refresh-table', function () {
            if (officersTable) officersTable.ajax.reload(null, false);
        });

        officersTable = $('#officers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url('api/officers') }}',
                type: 'GET',
                data: function (d) {
                    d.tipo_funcionario = tipoFuncionario;
                    d.estatus = currentEstatus;
                    return d;
                }
            },
            columns: [
                { data: 'numero_placa', className: 'text-center', render: d => d || 'S/NC' },
                { data: 'documento_identidad', className: 'text-center' },
                { data: 'nombre_completo', className: 'text-center' },
                { data: 'telefono', className: 'text-center', render: d => d || 'S/T' },
                { data: 'fecha_ingreso', className: 'text-center', render: d => d ? d.substr(0, 10) : 'S/F' },
                {
                    data: 'oficiales_cargos', className: 'text-center', orderable: false,
                    render: function (data) {
                        const cargo = data && data.length ? data.find(c => c.is_actual === 1) : null;
                        return cargo && cargo.cargo ? cargo.cargo.nombre_cargo : 'N/A';
                    }
                },
                {
                    data: 'cargos_administrativo', className: 'text-center', orderable: false,
                    render: d => d ? d.nombre_cargo : 'S/A'
                },
                {
                    data: 'estatus', className: 'text-center',
                    render: function (d) {
                        if (!d) return '';
                        const colors = {
                            'Operativo': 'badge-success',
                            'No Operativo': 'badge-secondary',
                            'Suspendido': 'badge-warning',
                            'Retirado': 'badge-dark',
                            'Jubilado': 'badge-info',
                            'Fallecido': 'badge-danger',
                            'URRA': 'badge-primary'
                        };
                        const cls = colors[d] || 'badge-light';
                        return `<span class="badge ${cls}">${d.toUpperCase()}</span>`;
                    }
                },
                {
                    data: 'id', className: 'text-right actions', orderable: false, searchable: false,
                    render: function (data) {
                        return `
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ url('/officers/tipo') }}/${tipoSlug}/${data}/edit"><i class="far fa-edit"></i> Editar</a>
                                    <a class="dropdown-item" href="{{ url('/officers/ficha') }}/${data}"><i class="fas fa-id-card-alt"></i> Ver ficha</a>
                                    <a class="dropdown-item" href="{{ url('/officers/radiogram') }}/${data}"><i class="fas fa-street-view"></i> Radiograma</a>
                                    <a class="dropdown-item" href="{{ url('/officers/academy') }}/${data}"><i class="fas fa-graduation-cap"></i> Formación académica</a>
                                    <a class="dropdown-item" href="{{ url('/officers/courses') }}/${data}"><i class="fas fa-book-reader"></i> Cursos y diplomados</a>
                                    <a class="dropdown-item" href="{{ url('/officers/positions') }}/${data}"><i class="fas fa-medal"></i> Jerarquías obtenidas</a>
                                    <a class="dropdown-item" href="{{ url('/officers/awards') }}/${data}"><i class="fas fa-trophy"></i> Reconocimientos</a>
                                    <a class="dropdown-item" href="{{ url('/officers/familly') }}/${data}"><i class="fab fa-gratipay"></i> Hijos y familiares</a>
                                    <a class="dropdown-item" href="{{ url('/officers/health') }}/${data}"><i class="fas fa-medkit"></i> Reposos médicos</a>
                                    <a class="dropdown-item" href="{{ url('/officers/icap') }}/${data}"><i class="fas fa-balance-scale"></i> ICAP</a>
                                    <a class="dropdown-item" href="{{ url('/officers/urra') }}/${data}"><i class="fas fa-shield-alt"></i> URRA</a>
                                    <button class="dropdown-item files" data-id="${data}" type="button"><i class="fas fa-file"></i> Archivos del oficial</button>
                                    <a class="dropdown-item" href="{{ url('/officers/vacations') }}/${data}"><i class="fas fa-plane-departure"></i> Solicitud de vacaciones</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item delete text-danger" data-id="${data}" type="button"><i class="far fa-trash-alt"></i> Eliminar</button>
                                </div>
                            </div>`;
                    }
                }
            ],
            language: dtEs,
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
            order: [[2, 'asc']],
            stateSave: false,
            autoWidth: false,
            responsive: true
        });

        // Evitar que DataTables recorte el menú de submódulos
        $('#officers-table').on('show.bs.dropdown', '.btn-group', function () {
            var $group = $(this);
            var $menu = $group.find('.dropdown-menu');
            var $toggle = $group.find('[data-toggle="dropdown"]');

            $group.data('officers-dropdown-menu', $menu);
            $('body').append($menu.detach());

            var offset = $toggle.offset();
            var toggleH = $toggle.outerHeight();
            var toggleW = $toggle.outerWidth();
            var menuW = $menu.outerWidth() || 240;
            var menuH = $menu.outerHeight() || 320;
            var top = offset.top + toggleH;
            var left = offset.left + toggleW - menuW;
            var viewportBottom = $(window).scrollTop() + $(window).height();

            if (top + menuH > viewportBottom - 8) {
                top = offset.top - menuH - 4;
            }

            $menu.css({
                position: 'absolute',
                top: Math.max(8, top) + 'px',
                left: Math.max(8, left) + 'px',
                display: 'block',
                zIndex: 1060
            });
        });

        $('#officers-table').on('hide.bs.dropdown', '.btn-group', function () {
            var $group = $(this);
            var $menu = $group.data('officers-dropdown-menu');
            if ($menu && $menu.length) {
                $menu.detach().appendTo($group);
                $menu.removeAttr('style');
            }
        });

        $(window).on('scroll.officersDropdown resize.officersDropdown', function () {
            $('#officers-table .btn-group.show .dropdown-toggle').dropdown('hide');
        });

        document.querySelectorAll('.estatus-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.estatus-tab').forEach(function (t) {
                    t.classList.remove('is-active');
                    t.setAttribute('aria-selected', 'false');
                });
                tab.classList.add('is-active');
                tab.setAttribute('aria-selected', 'true');
                currentEstatus = tab.getAttribute('data-estatus') || '';
                officersTable.ajax.reload();
            });
        });

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            id = $(this).data('id');
            const formData = new FormData();
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
                fetch('{{ url('api/officers') }}/' + id, { method: 'POST', body: formData })
                    .then(r => r.json())
                    .then(data => {
                        Swal.fire({ title: data.msj || 'Eliminado', icon: 'success' });
                        officersTable.ajax.reload(null, false);
                    });
            });
        });

        $(document).on('click', '.files', function () {
            id = $(this).attr('data-id');
            if (!Dropzone.instances.length) {
                new Dropzone('#myDropzone', {
                    url: '{{ url('api/officers/files/add-files') }}/' + id,
                    method: 'POST',
                    paramName: 'archivos',
                    maxFilesize: 2,
                    acceptedFiles: '.jpg,.jpeg,.png',
                    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos',
                    success: function () { index_archivos(id); }
                });
            }
            $('#modal-archivos').modal('show');
            index_archivos(id);
        });

        $(document).on('click', '.delete-file', function (e) {
            e.preventDefault();
            const fileId = $(this).data('id');
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;
                fetch('{{ url('api/officers/files') }}/' + fileId, { method: 'POST', body: formData })
                    .then(r => r.json())
                    .then(data => {
                        Swal.fire('Eliminado', data.msj, 'success');
                        index_archivos(id);
                    });
            });
        });
    });

    function index_archivos(officerId) {
        fetch('{{ url('api/officers/files/index') }}/' + (officerId || id))
            .then(r => r.json())
            .then(data => {
                let html = '';
                (data || []).forEach(file => {
                    html += `<div class="col-md-3 mb-3 text-center">
                        <img src="storage/${file.archivo_url || file.archivo}" class="img-thumbnail" style="height:100px;object-fit:cover;">
                        <button class="btn btn-sm btn-danger delete-file mt-2" data-id="${file.id}">Eliminar</button>
                    </div>`;
                });
                $('#archivos-index').html(html || '<div class="col-12 text-muted">Sin archivos</div>');
            })
            .catch(() => $('#archivos-index').html('<div class="col-12 text-muted">Sin archivos</div>'));
    }
</script>
@endsection
