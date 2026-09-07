@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ public_asset('css/cpet-file-gallery.css') }}">
<style>
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
        white-space: nowrap;
    }
    .estatus-tab:hover { color: #1a4574; background: rgba(255,255,255,.75); }
    .estatus-tab.is-active {
        color: #0f2744;
        background: #fff;
        position: relative;
    }
    .estatus-tab.is-active::after {
        content: "";
        position: absolute;
        left: .65rem; right: .65rem; bottom: 0;
        height: 3px; border-radius: 999px;
        background: linear-gradient(90deg, #c4922e, #d4a84b);
    }
    .estatus-tab__count {
        display: inline-flex;
        min-width: 1.35rem;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: .1rem .45rem;
        font-size: .7rem;
        font-weight: 700;
        background: #e2e8f0;
        color: #475569;
    }
    .estatus-tab.is-active .estatus-tab__count {
        background: #1a4574;
        color: #fff;
    }
    .estatus-tabs-wrap { overflow-x: auto; scrollbar-width: thin; }

    .officers-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .officers-toolbar input[type="search"] {
        min-width: min(100%, 280px);
    }
    .officers-meta {
        font-size: .85rem;
        color: #64748b;
    }
    .officers-pager {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
    }
    .officers-pager .btn[disabled] { opacity: .45; cursor: not-allowed; }

    .officers-table-panel,
    .officers-table-panel .table-responsive {
        overflow: visible !important;
    }
    .officers-table-panel td.actions {
        overflow: visible !important;
        position: relative;
        white-space: nowrap;
    }
    .officers-submodulos-menu {
        z-index: 1060;
        max-height: min(70vh, 28rem);
        overflow-y: auto;
    }
    #officers-tbody tr { cursor: default; }
    #officers-loading {
        display: none;
        text-align: center;
        padding: 1.5rem;
        color: #64748b;
    }
    #officers-loading.is-on { display: block; }
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
                <div class="row cpet-file-gallery" id="archivos-index"></div>
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
        <div class="officers-toolbar">
            <input type="search" id="officers-search" class="form-control" placeholder="Buscar cédula, nombre, placa, cargo…">
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0 text-muted small" for="officers-per-page">Por página</label>
                <select id="officers-per-page" class="form-control form-control-sm" style="width:auto;">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div id="officers-loading"><i class="fas fa-spinner fa-spin"></i> Cargando…</div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" id="officers-table">
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
                <tbody id="officers-tbody"></tbody>
            </table>
        </div>

        <div class="officers-pager">
            <div class="officers-meta" id="officers-info">—</div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="officers-prev">Anterior</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="officers-next">Siguiente</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/dropzone/dropzone.min.js') }}"></script>
<script src="{{ public_asset('js/cpet-file-gallery.js') }}"></script>
<script>
(function () {
    Dropzone.autoDiscover = false;

    var apiBase = @json(url('api/officers'));
    var storageBase = @json(public_asset('storage'));
    var filesApiBase = @json(url('api/officers/files'));
    var tipoFuncionario = @json($tipoFuncionario);
    var tipoSlug = @json($tipo);
    var placaSin = @json(\App\Models\Oficiale::PLACA_SIN_ASIGNAR);

    var state = {
        page: 1,
        perPage: 25,
        q: '',
        estatus: '',
        total: 0,
        lastPage: 1,
        loading: false
    };
    var searchTimer = null;
    var officerDropzone = null;
    var currentFilesId = '';

    var estatusColors = {
        'Operativo': 'badge-success',
        'No Operativo': 'badge-secondary',
        'En Reposo': 'badge-warning',
        'Reingreso': 'badge-info',
        'Suspendido': 'badge-warning',
        'Retirado': 'badge-dark',
        'Jubilado': 'badge-info',
        'Fallecido': 'badge-danger',
        'URRA': 'badge-primary'
    };

    function esc(v) {
        return String(v == null ? '' : v)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function badgeEstatus(estatus, tipoRetiro) {
        if (!estatus) return '';
        var cls = estatusColors[estatus] || 'badge-light';
        var label = String(estatus).toUpperCase();
        if (estatus === 'Retirado' && tipoRetiro) {
            label += ' (' + String(tipoRetiro).toUpperCase() + ')';
        }
        return '<span class="badge ' + cls + '">' + esc(label) + '</span>';
    }

    function actionsHtml(id) {
        return '' +
            '<div class="btn-group">' +
                '<button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">' +
                    '<i class="fas fa-ellipsis-v"></i>' +
                '</button>' +
                '<div class="dropdown-menu dropdown-menu-right officers-submodulos-menu">' +
                    '<a class="dropdown-item" href="{{ url('/officers/tipo') }}/' + tipoSlug + '/' + id + '/edit"><i class="far fa-edit"></i> Editar</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/ficha') }}/' + id + '"><i class="fas fa-id-card-alt"></i> Ver ficha</a>' +
                    '<div class="dropdown-divider"></div>' +
                    '<a class="dropdown-item" href="{{ url('/officers/radiogram') }}/' + id + '"><i class="fas fa-street-view"></i> Radiograma</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/nombramientos') }}/' + id + '"><i class="fas fa-user-tie"></i> Nombramientos</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/academy') }}/' + id + '"><i class="fas fa-graduation-cap"></i> Formación académica</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/courses') }}/' + id + '"><i class="fas fa-book-reader"></i> Cursos y diplomados</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/positions') }}/' + id + '"><i class="fas fa-medal"></i> Jerarquías obtenidas</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/awards') }}/' + id + '"><i class="fas fa-trophy"></i> Reconocimientos</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/familly') }}/' + id + '"><i class="fab fa-gratipay"></i> Hijos y familiares</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/health') }}/' + id + '"><i class="fas fa-medkit"></i> Reposos médicos</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/icap') }}/' + id + '"><i class="fas fa-balance-scale"></i> ICAP</a>' +
                    '<a class="dropdown-item" href="{{ url('/officers/urra') }}/' + id + '"><i class="fas fa-shield-alt"></i> URRA</a>' +
                    '<button class="dropdown-item files" data-id="' + id + '" type="button"><i class="fas fa-file"></i> Archivos del oficial</button>' +
                    '<a class="dropdown-item" href="{{ url('/officers/vacations') }}/' + id + '"><i class="fas fa-plane-departure"></i> Vacaciones</a>' +
                    '<div class="dropdown-divider"></div>' +
                    '<button class="dropdown-item delete text-danger" data-id="' + id + '" type="button"><i class="far fa-trash-alt"></i> Eliminar</button>' +
                '</div>' +
            '</div>';
    }

    function renderRows(rows) {
        var tbody = document.getElementById('officers-tbody');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-4">Sin resultados</td></tr>';
            return;
        }
        var html = '';
        rows.forEach(function (r) {
            html += '<tr>' +
                '<td class="text-center">' + esc(r.numero_placa || placaSin) + '</td>' +
                '<td class="text-center">' + esc(r.documento_identidad || '') + '</td>' +
                '<td class="text-center">' + esc(r.nombre_completo || '') + '</td>' +
                '<td class="text-center">' + esc(r.telefono || 'S/T') + '</td>' +
                '<td class="text-center">' + esc(r.fecha_ingreso || 'S/F') + '</td>' +
                '<td class="text-center">' + esc(r.jerarquia || 'N/A') + '</td>' +
                '<td class="text-center">' + esc(r.cargo || 'S/A') + '</td>' +
                '<td class="text-center">' + badgeEstatus(r.estatus, r.tipo_retiro) + '</td>' +
                '<td class="text-right actions">' + actionsHtml(r.id) + '</td>' +
            '</tr>';
        });
        tbody.innerHTML = html;
    }

    function updatePager() {
        var from = state.total === 0 ? 0 : ((state.page - 1) * state.perPage) + 1;
        var to = Math.min(state.page * state.perPage, state.total);
        document.getElementById('officers-info').textContent =
            'Mostrando ' + from + '–' + to + ' de ' + state.total;
        document.getElementById('officers-prev').disabled = state.page <= 1 || state.loading;
        document.getElementById('officers-next').disabled = state.page >= state.lastPage || state.loading;
    }

    function loadOfficers() {
        if (state.loading) return;
        state.loading = true;
        document.getElementById('officers-loading').classList.add('is-on');
        updatePager();

        var params = new URLSearchParams({
            page: String(state.page),
            per_page: String(state.perPage),
            tipo_funcionario: tipoFuncionario
        });
        if (state.estatus) params.set('estatus', state.estatus);
        if (state.q) params.set('q', state.q);

        fetch(apiBase + '?' + params.toString(), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(function (r) {
                return r.json().then(function (json) {
                    return { ok: r.ok, json: json };
                });
            })
            .then(function (res) {
                if (!res.ok || res.json.error) {
                    var msg = (res.json && (res.json.detail || res.json.error)) || 'Error al cargar funcionarios';
                    document.getElementById('officers-tbody').innerHTML =
                        '<tr><td colspan="9" class="text-center text-danger py-4">' + esc(msg) + '</td></tr>';
                    state.total = 0;
                    state.lastPage = 1;
                    return;
                }
                var meta = res.json.meta || {};
                state.total = meta.total || 0;
                state.lastPage = meta.last_page || 1;
                state.page = meta.page || state.page;
                renderRows(res.json.data || []);
            })
            .catch(function () {
                document.getElementById('officers-tbody').innerHTML =
                    '<tr><td colspan="9" class="text-center text-danger py-4">No se pudo conectar con el servidor</td></tr>';
            })
            .finally(function () {
                state.loading = false;
                document.getElementById('officers-loading').classList.remove('is-on');
                updatePager();
            });
    }

    function index_archivos(officerId) {
        fetch(filesApiBase + '/index/' + (officerId || currentFilesId))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                CpetFileGallery.render('#archivos-index', data || [], {
                    storageBase: storageBase,
                    contextId: officerId || currentFilesId,
                    deleteUrl: function (fileId) { return filesApiBase + '/' + fileId; },
                    onDeleted: function () { index_archivos(officerId || currentFilesId); }
                });
            })
            .catch(function () {
                $('#archivos-index').html('<div class="col-12 text-muted text-center py-3">Sin archivos</div>');
            });
    }

    document.getElementById('officers-search').addEventListener('input', function (e) {
        clearTimeout(searchTimer);
        var value = e.target.value.trim();
        searchTimer = setTimeout(function () {
            state.q = value;
            state.page = 1;
            loadOfficers();
        }, 280);
    });

    document.getElementById('officers-per-page').addEventListener('change', function (e) {
        state.perPage = parseInt(e.target.value, 10) || 25;
        state.page = 1;
        loadOfficers();
    });

    document.getElementById('officers-prev').addEventListener('click', function () {
        if (state.page <= 1) return;
        state.page -= 1;
        loadOfficers();
    });

    document.getElementById('officers-next').addEventListener('click', function () {
        if (state.page >= state.lastPage) return;
        state.page += 1;
        loadOfficers();
    });

    document.querySelectorAll('.estatus-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.estatus-tab').forEach(function (t) {
                t.classList.remove('is-active');
                t.setAttribute('aria-selected', 'false');
            });
            tab.classList.add('is-active');
            tab.setAttribute('aria-selected', 'true');
            state.estatus = tab.getAttribute('data-estatus') || '';
            state.page = 1;
            loadOfficers();
        });
    });

    document.addEventListener('click', function (e) {
        var del = e.target.closest('.delete');
        if (del) {
            e.preventDefault();
            var id = del.getAttribute('data-id');
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
                fetch(apiBase + '/' + id, { method: 'POST', body: formData })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        Swal.fire({ title: data.msj || 'Eliminado', icon: 'success' });
                        loadOfficers();
                    });
            });
            return;
        }

        var filesBtn = e.target.closest('.files');
        if (filesBtn) {
            currentFilesId = filesBtn.getAttribute('data-id');
            if (officerDropzone) {
                officerDropzone.destroy();
                officerDropzone = null;
            }
            officerDropzone = new Dropzone('#myDropzone', {
                url: filesApiBase + '/add-files/' + currentFilesId,
                method: 'POST',
                paramName: 'archivos',
                maxFilesize: 10,
                acceptedFiles: '.jpg,.jpeg,.png,.pdf',
                dictDefaultMessage: 'Arrastra los archivos aquí para subirlos',
                success: function () { index_archivos(currentFilesId); }
            });
            $('#modal-archivos').modal('show');
            index_archivos(currentFilesId);
        }
    });

    document.addEventListener('cpet:refresh-table', loadOfficers);

    // Menú flotante para que no lo recorte la tabla
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
        if (top + menuH > viewportBottom - 8) top = offset.top - menuH - 4;
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

    loadOfficers();
})();
</script>
@endsection
