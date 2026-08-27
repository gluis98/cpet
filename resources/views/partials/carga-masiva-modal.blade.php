<style>
    #cargaMasivaModal .modal-dialog {
        max-width: 920px;
    }

    #cargaMasivaModal .modal-content {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(15, 39, 68, 0.22);
    }

    #cargaMasivaModal .modal-header {
        background: linear-gradient(135deg, #0f2744 0%, #1a4574 100%) !important;
        color: #fff !important;
        border: 0 !important;
        padding: 1rem 1.25rem;
    }

    #cargaMasivaModal .modal-header .modal-title,
    #cargaMasivaModal .modal-header small {
        color: #fff !important;
    }

    #cargaMasivaModal .modal-header .close {
        color: #fff !important;
        opacity: 0.85;
        text-shadow: none;
    }

    #cargaMasivaModal .modal-body {
        padding: 0;
    }

    #cargaMasivaModal .modal-footer {
        border-top: 1px solid #e8eef5;
        background: #f8fafc;
    }

    .carga-layout {
        display: flex;
        min-height: 420px;
        max-height: min(72vh, 560px);
    }

    .carga-sidebar {
        flex: 0 0 240px;
        background: linear-gradient(180deg, #f8fafc 0%, #eef3f9 100%);
        border-right: 1px solid #e2e8f0;
        overflow-y: auto;
        padding: 0.75rem 0.5rem;
    }

    .carga-sidebar__group {
        margin-bottom: 0.85rem;
    }

    .carga-sidebar__label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        padding: 0.35rem 0.75rem 0.25rem;
    }

    .carga-sidebar__item {
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
        width: 100%;
        border: 0;
        border-radius: 0.65rem;
        background: transparent;
        text-align: left;
        padding: 0.6rem 0.75rem;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: background 0.15s, color 0.15s, box-shadow 0.15s;
    }

    .carga-sidebar__item i {
        width: 1.1rem;
        margin-top: 0.1rem;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .carga-sidebar__item:hover {
        background: rgba(255, 255, 255, 0.85);
        color: #1a4574;
    }

    .carga-sidebar__item.is-active {
        background: #fff;
        color: #0f2744;
        box-shadow: 0 2px 8px rgba(15, 39, 68, 0.08);
        font-weight: 600;
    }

    .carga-sidebar__item.is-active i {
        color: #c4922e;
    }

    .carga-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: #fff;
    }

    .carga-panel__head {
        padding: 1.25rem 1.5rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .carga-panel__head h4 {
        margin: 0 0 0.35rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f2744 !important;
    }

    .carga-panel__head p {
        margin: 0;
        font-size: 0.8125rem;
        color: #64748b !important;
        line-height: 1.45;
    }

    .carga-panel__body {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem 1.5rem 1.5rem;
    }

    .carga-panel__section {
        display: none;
    }

    .carga-panel__section.is-active {
        display: block;
    }

    .carga-guide {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.75rem;
        margin-bottom: 1rem;
    }

    .carga-guide th,
    .carga-guide td {
        border: 1px solid #e2e8f0;
        padding: 0.4rem 0.5rem;
        vertical-align: top;
        text-align: left;
    }

    .carga-guide th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 600;
    }

    .carga-guide .req {
        color: #b45309;
        font-weight: 700;
    }

    .carga-notes {
        list-style: none;
        padding: 0;
        margin: 0 0 1rem;
    }

    .carga-notes li {
        font-size: 0.78rem;
        color: #475569;
        padding: 0.25rem 0;
        padding-left: 1rem;
        position: relative;
    }

    .carga-notes li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #c4922e;
        font-weight: 700;
    }

    .carga-panel .form-group label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.35rem;
    }

    .carga-panel .form-control {
        border-radius: 0.55rem;
        border-color: #c9d5e3;
        font-size: 0.875rem;
    }

    .carga-result {
        display: none;
        margin-top: 1rem;
        font-size: 0.8125rem;
        border-radius: 0.65rem;
        padding: 0.75rem 1rem;
    }

    .carga-result.is-ok {
        display: block;
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .carga-result.is-err {
        display: block;
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .carga-result ul {
        margin: 0.5rem 0 0;
        padding-left: 1.1rem;
        max-height: 120px;
        overflow-y: auto;
    }

    @media (max-width: 767px) {
        .carga-layout {
            flex-direction: column;
            max-height: none;
        }

        .carga-sidebar {
            flex: none;
            max-height: 180px;
            border-right: 0;
            border-bottom: 1px solid #e2e8f0;
        }
    }
</style>

@php
    $cargaModules = \App\Support\BulkImport\BulkImportRegistry::modules();
    $cargaGroups = [];
    foreach ($cargaModules as $key => $mod) {
        $cargaGroups[$mod['group']][$key] = $mod;
    }
    $cargaFirstKey = array_key_first($cargaModules);
@endphp

<div class="modal fade" id="cargaMasivaModal" tabindex="-1" role="dialog" aria-labelledby="cargaMasivaModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0" id="cargaMasivaModalLabel">
                        <i class="fas fa-file-excel mr-2"></i> Carga masiva
                    </h5>
                    <small class="d-block mt-1" style="opacity: 0.85;">Seleccione el módulo, descargue la plantilla y suba el Excel completado</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="carga-layout">
                    <nav class="carga-sidebar" aria-label="Módulos de carga">
                        @foreach ($cargaGroups as $group => $items)
                            <div class="carga-sidebar__group">
                                <div class="carga-sidebar__label">{{ $group }}</div>
                                @foreach ($items as $key => $mod)
                                    <button type="button"
                                            class="carga-sidebar__item {{ $key === $cargaFirstKey ? 'is-active' : '' }}"
                                            data-carga="{{ $key }}">
                                        <i class="{{ $mod['icon'] }}"></i>
                                        <span>{{ $mod['title'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        @endforeach
                    </nav>

                    <div class="carga-panel">
                        <div class="carga-panel__head">
                            <h4 id="carga-panel-title">{{ $cargaModules[$cargaFirstKey]['title'] }}</h4>
                            <p id="carga-panel-desc">{{ $cargaModules[$cargaFirstKey]['description'] }}</p>
                        </div>

                        <div class="carga-panel__body">
                            @foreach ($cargaModules as $key => $mod)
                                <div class="carga-panel__section {{ $key === $cargaFirstKey ? 'is-active' : '' }}"
                                     data-carga-panel="{{ $key }}">
                                    <div class="d-flex flex-wrap align-items-center mb-3" style="gap: 0.5rem;">
                                        <a href="{{ route('bulk-import.template', $key) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download mr-1"></i> Descargar plantilla
                                        </a>
                                    </div>

                                    <p class="text-muted small mb-2 font-weight-bold" style="color:#334155 !important;">
                                        Columnas del Excel
                                    </p>
                                    <div style="max-height: 160px; overflow-y: auto; margin-bottom: 0.75rem;">
                                        <table class="carga-guide">
                                            <thead>
                                            <tr>
                                                <th>Campo</th>
                                                <th>Req.</th>
                                                <th>Descripción</th>
                                                <th>Ejemplo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($mod['columns'] as $col)
                                                <tr>
                                                    <td><code>{{ $col['label'] }}</code></td>
                                                    <td class="{{ $col['required'] ? 'req' : '' }}">
                                                        {{ $col['required'] ? 'Sí' : 'No' }}
                                                    </td>
                                                    <td>{{ $col['help'] ?? '' }}</td>
                                                    <td>{{ $col['example'] ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if (! empty($mod['notes']))
                                        <ul class="carga-notes">
                                            @foreach ($mod['notes'] as $note)
                                                <li>{{ $note }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <form class="carga-import-form" data-module="{{ $key }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="module" value="{{ $key }}">
                                        <div class="form-group">
                                            <label for="carga_file_{{ $key }}">Archivo Excel (.xlsx)</label>
                                            <input type="file"
                                                   name="file"
                                                   id="carga_file_{{ $key }}"
                                                   class="form-control-file"
                                                   accept=".xlsx,.xls,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                   required>
                                        </div>
                                        <button type="submit" class="btn btn-primary carga-submit-btn">
                                            <i class="fas fa-upload mr-1"></i> Importar
                                        </button>
                                        <div class="carga-result" data-carga-result="{{ $key }}"></div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var meta = @json(collect($cargaModules)->mapWithKeys(fn ($m, $k) => [$k => ['title' => $m['title'], 'desc' => $m['description']]]));
    var importUrl = @json(route('bulk-import.import'));

    function activateCarga(key) {
        var info = meta[key] || {};

        document.querySelectorAll('.carga-sidebar__item').forEach(function (btn) {
            btn.classList.toggle('is-active', btn.getAttribute('data-carga') === key);
        });

        document.querySelectorAll('.carga-panel__section').forEach(function (panel) {
            panel.classList.toggle('is-active', panel.getAttribute('data-carga-panel') === key);
        });

        var titleEl = document.getElementById('carga-panel-title');
        var descEl = document.getElementById('carga-panel-desc');
        if (titleEl) titleEl.textContent = info.title || '';
        if (descEl) descEl.textContent = info.desc || '';
    }

    document.querySelectorAll('.carga-sidebar__item').forEach(function (btn) {
        btn.addEventListener('click', function () {
            activateCarga(btn.getAttribute('data-carga'));
        });
    });

    var modal = document.getElementById('cargaMasivaModal');
    if (modal && typeof $ !== 'undefined') {
        $(modal).on('shown.bs.modal', function () {
            var active = document.querySelector('.carga-sidebar__item.is-active');
            activateCarga(active ? active.getAttribute('data-carga') : '{{ $cargaFirstKey }}');
        });
    }

    document.querySelectorAll('.carga-import-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var module = form.getAttribute('data-module');
            var resultEl = form.querySelector('[data-carga-result]');
            var btn = form.querySelector('.carga-submit-btn');
            var fd = new FormData(form);

            if (resultEl) {
                resultEl.className = 'carga-result';
                resultEl.innerHTML = '';
            }
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Importando…';
            }

            fetch(importUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: fd,
                credentials: 'same-origin'
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return { status: res.status, data: data };
                    }).catch(function () {
                        return { status: res.status, data: { ok: false, msj: 'Respuesta inválida del servidor.' } };
                    });
                })
                .then(function (payload) {
                    var data = payload.data || {};
                    var ok = !!data.ok;
                    if (!ok && data.errors && !Array.isArray(data.errors) && typeof data.errors === 'object') {
                        var msgs = [];
                        Object.keys(data.errors).forEach(function (k) {
                            (data.errors[k] || []).forEach(function (m) { msgs.push(m); });
                        });
                        data.msj = data.message || 'Revise el archivo enviado.';
                        data.errors = msgs;
                    }
                    if (resultEl) {
                        resultEl.className = 'carga-result ' + (ok ? 'is-ok' : 'is-err');
                        var html = '<strong>' + (data.msj || (ok ? 'Listo' : 'Error')) + '</strong>';
                        if (data.errors && data.errors.length) {
                            html += '<ul>' + data.errors.map(function (err) {
                                return '<li>' + err + '</li>';
                            }).join('') + '</ul>';
                        }
                        resultEl.innerHTML = html;
                    }
                    if (ok) {
                        $(document).trigger('cpet:refresh-table');
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Importación completada',
                                text: data.msj || '',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2800,
                                timerProgressBar: true
                            });
                        }
                    }
                })
                .catch(function () {
                    if (resultEl) {
                        resultEl.className = 'carga-result is-err';
                        resultEl.innerHTML = '<strong>No se pudo procesar el archivo.</strong>';
                    }
                })
                .finally(function () {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-upload mr-1"></i> Importar';
                    }
                });
        });
    });
});
</script>
