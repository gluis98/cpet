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

    .carga-result.is-warn {
        display: block;
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .carga-result__stats {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 0.65rem 0;
    }

    .carga-result__stat {
        background: rgba(255, 255, 255, 0.65);
        border-radius: 0.5rem;
        padding: 0.35rem 0.6rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .carga-result__errors {
        margin: 0.5rem 0 0;
        padding-left: 1.1rem;
        max-height: 220px;
        overflow-y: auto;
        font-size: 0.78rem;
        line-height: 1.45;
    }

    .carga-result__actions {
        margin-top: 0.65rem;
    }

    .carga-result ul {
        margin: 0.5rem 0 0;
        padding-left: 1.1rem;
        max-height: 220px;
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
    .carga-foto-dz {
        border: 2px dashed #94a3b8;
        border-radius: 1rem;
        background: linear-gradient(180deg, #f8fafc 0%, #eef4fb 100%);
        padding: 1.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
        user-select: none;
    }

    .carga-foto-dz:hover,
    .carga-foto-dz.is-dragover {
        border-color: #1a4574;
        background: linear-gradient(180deg, #eef4fb 0%, #fff 100%);
        box-shadow: 0 0 0 4px rgba(26, 69, 116, 0.12);
    }

    .carga-foto-dz__icon {
        font-size: 2rem;
        color: #1a4574;
        margin-bottom: 0.5rem;
    }

    .carga-foto-dz__title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f2744;
        margin: 0 0 0.25rem;
    }

    .carga-foto-dz__hint {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
    }

    .carga-foto-dz__example {
        margin-top: 0.75rem;
        font-size: 0.78rem;
        color: #475569;
    }

    .carga-foto-dz__example code {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.35rem;
        padding: 0.15rem 0.4rem;
        color: #1a4574;
    }

    .carga-foto-list {
        list-style: none;
        margin: 0.85rem 0 0;
        padding: 0;
        max-height: 140px;
        overflow-y: auto;
        text-align: left;
    }

    .carga-foto-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        font-size: 0.78rem;
        color: #334155;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.4rem 0.6rem;
        margin-bottom: 0.35rem;
    }

    .carga-foto-list li span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .carga-foto-list .carga-foto-remove {
        border: 0;
        background: transparent;
        color: #b91c1c;
        cursor: pointer;
        padding: 0 0.2rem;
        flex-shrink: 0;
    }

    .carga-foto-count {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #1a4574;
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
                    <small class="d-block mt-1" style="opacity: 0.85;">Seleccione el módulo, descargue la guía/plantilla y suba el archivo</small>
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
                                @php $isImages = ($mod['format'] ?? 'excel') === 'images'; @endphp
                                <div class="carga-panel__section {{ $key === $cargaFirstKey ? 'is-active' : '' }}"
                                     data-carga-panel="{{ $key }}">
                                    <div class="d-flex flex-wrap align-items-center mb-3" style="gap: 0.5rem;">
                                        <a href="{{ route('bulk-import.template', $key) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-download mr-1"></i>
                                            {{ $mod['template_label'] ?? 'Descargar plantilla' }}
                                        </a>
                                    </div>

                                    @if (! $isImages)
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
                                    @endif

                                    @if (! empty($mod['notes']))
                                        <ul class="carga-notes">
                                            @foreach ($mod['notes'] as $note)
                                                <li>{{ $note }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <form class="carga-import-form"
                                          data-module="{{ $key }}"
                                          data-format="{{ $mod['format'] ?? 'excel' }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="module" value="{{ $key }}">

                                        @if ($isImages)
                                            <div class="carga-foto-dz"
                                                 id="carga_foto_dz_{{ $key }}"
                                                 role="button"
                                                 tabindex="0"
                                                 aria-label="Seleccionar fotografías">
                                                <div class="carga-foto-dz__icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                                <p class="carga-foto-dz__title">Arrastre las fotos aquí</p>
                                                <p class="carga-foto-dz__hint">o haga clic para seleccionar varias a la vez</p>
                                                <p class="carga-foto-dz__example">
                                                    Cada foto debe llamarse como la cédula:
                                                    <code>12345678.jpg</code>
                                                </p>
                                                <input type="file"
                                                       name="files[]"
                                                       id="carga_file_{{ $key }}"
                                                       class="d-none carga-foto-input"
                                                       accept="{{ $mod['accept'] }}"
                                                       multiple>
                                            </div>
                                            <div class="carga-foto-count" id="carga_foto_count_{{ $key }}" hidden>
                                                0 fotos seleccionadas
                                            </div>
                                            <ul class="carga-foto-list" id="carga_foto_list_{{ $key }}"></ul>
                                        @else
                                            <div class="form-group">
                                                <label for="carga_file_{{ $key }}">{{ $mod['file_label'] ?? 'Archivo Excel (.xlsx)' }}</label>
                                                <input type="file"
                                                       name="file"
                                                       id="carga_file_{{ $key }}"
                                                       class="form-control-file"
                                                       accept="{{ $mod['accept'] ?? '.xlsx,.xls,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }}"
                                                       required>
                                            </div>
                                        @endif

                                        <button type="submit" class="btn btn-primary carga-submit-btn mt-2">
                                            <i class="fas fa-upload mr-1"></i>
                                            {{ $isImages ? 'Subir fotografías' : 'Importar' }}
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

    var fotoBags = {};

    function syncFotoInput(module) {
        var input = document.getElementById('carga_file_' + module);
        var bag = fotoBags[module] || [];
        if (!input) return;
        var dt = new DataTransfer();
        bag.forEach(function (file) { dt.items.add(file); });
        input.files = dt.files;
    }

    function renderFotoList(module) {
        var list = document.getElementById('carga_foto_list_' + module);
        var countEl = document.getElementById('carga_foto_count_' + module);
        var bag = fotoBags[module] || [];
        if (!list || !countEl) return;

        list.innerHTML = '';
        bag.forEach(function (file, idx) {
            var li = document.createElement('li');
            var name = document.createElement('span');
            name.textContent = file.name + ' (' + Math.max(1, Math.round(file.size / 1024)) + ' KB)';
            var btnRm = document.createElement('button');
            btnRm.type = 'button';
            btnRm.className = 'carga-foto-remove';
            btnRm.title = 'Quitar';
            btnRm.innerHTML = '<i class="fas fa-times"></i>';
            btnRm.addEventListener('click', function (ev) {
                ev.preventDefault();
                ev.stopPropagation();
                fotoBags[module].splice(idx, 1);
                syncFotoInput(module);
                renderFotoList(module);
            });
            li.appendChild(name);
            li.appendChild(btnRm);
            list.appendChild(li);
        });

        countEl.hidden = bag.length === 0;
        countEl.textContent = bag.length === 1
            ? '1 foto seleccionada'
            : (bag.length + ' fotos seleccionadas');
    }

    function addFotoFiles(module, fileList) {
        if (!fotoBags[module]) fotoBags[module] = [];
        var existing = {};
        fotoBags[module].forEach(function (f) { existing[f.name + '|' + f.size] = true; });

        Array.prototype.forEach.call(fileList || [], function (file) {
            if (!file.type || file.type.indexOf('image/') !== 0) return;
            var key = file.name + '|' + file.size;
            if (existing[key]) return;
            if (fotoBags[module].length >= 100) return;
            fotoBags[module].push(file);
            existing[key] = true;
        });

        syncFotoInput(module);
        renderFotoList(module);
    }

    document.querySelectorAll('.carga-foto-dz').forEach(function (dz) {
        var input = dz.querySelector('.carga-foto-input');
        if (!input) return;
        var moduleKey = (input.id || '').replace('carga_file_', '');
        fotoBags[moduleKey] = [];

        dz.addEventListener('click', function () { input.click(); });
        dz.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                input.click();
            }
        });

        ['dragenter', 'dragover'].forEach(function (evt) {
            dz.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dz.classList.add('is-dragover');
            });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            dz.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
                dz.classList.remove('is-dragover');
            });
        });
        dz.addEventListener('drop', function (e) {
            addFotoFiles(moduleKey, e.dataTransfer && e.dataTransfer.files);
        });
        input.addEventListener('change', function () {
            addFotoFiles(moduleKey, input.files);
            syncFotoInput(moduleKey);
        });
    });

    document.querySelectorAll('.carga-import-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var module = form.getAttribute('data-module');
            var format = form.getAttribute('data-format') || 'excel';
            var resultEl = form.querySelector('[data-carga-result]');
            var btn = form.querySelector('.carga-submit-btn');

            if (format === 'images') {
                syncFotoInput(module);
                var fotoInput = document.getElementById('carga_file_' + module);
                if (!fotoInput || !fotoInput.files || !fotoInput.files.length) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'warning', title: 'Sin fotos', text: 'Seleccione o arrastre al menos una fotografía.' });
                    } else {
                        alert('Seleccione o arrastre al menos una fotografía.');
                    }
                    return;
                }
            }

            var fd = new FormData(form);

            if (resultEl) {
                resultEl.className = 'carga-result';
                resultEl.innerHTML = '';
            }
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> ' + (format === 'images' ? 'Subiendo…' : 'Importando…');
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

                    var errors = Array.isArray(data.errors) ? data.errors : [];
                    var hasIssues = !!(data.has_issues || data.failed > 0 || data.skipped > 0 || errors.length);

                    if (resultEl) {
                        var resultClass = 'carga-result ';
                        if (!ok) {
                            resultClass += 'is-err';
                        } else if (hasIssues) {
                            resultClass += 'is-warn';
                        } else {
                            resultClass += 'is-ok';
                        }
                        resultEl.className = resultClass;

                        var html = '<strong>' + (data.msj || (ok ? 'Importación completada' : 'Error en la importación')) + '</strong>';

                        if (ok && (data.total_rows != null)) {
                            html += '<div class="carga-result__stats">';
                            html += '<span class="carga-result__stat">Procesadas: ' + (data.total_rows || 0) + '</span>';
                            if (format === 'images') {
                                html += '<span class="carga-result__stat">Asignadas: ' + (data.updated || 0) + '</span>';
                            } else {
                                html += '<span class="carga-result__stat">Creados: ' + (data.created || 0) + '</span>';
                                html += '<span class="carga-result__stat">Actualizados: ' + (data.updated || 0) + '</span>';
                            }
                            html += '<span class="carga-result__stat">Omitidos: ' + (data.skipped || 0) + '</span>';
                            html += '<span class="carga-result__stat">Errores: ' + (data.failed || 0) + '</span>';
                            if ((data.deduped || 0) > 0) {
                                html += '<span class="carga-result__stat">Duplicados eliminados: ' + data.deduped + '</span>';
                            }
                            html += '</div>';
                        }

                        if (errors.length) {
                            html += '<ol class="carga-result__errors">';
                            errors.forEach(function (err) {
                                html += '<li>' + String(err).replace(/</g, '&lt;') + '</li>';
                            });
                            html += '</ol>';
                            html += '<div class="carga-result__actions">';
                            html += '<button type="button" class="btn btn-sm btn-outline-dark carga-download-errors">';
                            html += '<i class="fas fa-download mr-1"></i> Descargar reporte (.txt)</button>';
                            html += '</div>';
                            resultEl._cargaErrors = errors;
                        } else {
                            resultEl._cargaErrors = [];
                        }

                        resultEl.innerHTML = html;

                        var dlBtn = resultEl.querySelector('.carga-download-errors');
                        if (dlBtn) {
                            dlBtn.addEventListener('click', function () {
                                var lines = (resultEl._cargaErrors || []).join('\n');
                                var blob = new Blob([lines], { type: 'text/plain;charset=utf-8' });
                                var a = document.createElement('a');
                                a.href = URL.createObjectURL(blob);
                                a.download = 'importacion-errores-' + module + '-' + new Date().toISOString().slice(0, 10) + '.txt';
                                a.click();
                                URL.revokeObjectURL(a.href);
                            });
                        }
                    }

                    if (ok) {
                        if (format === 'images') {
                            fotoBags[module] = [];
                            syncFotoInput(module);
                            renderFotoList(module);
                        }
                        if ((data.created || 0) > 0 || (data.updated || 0) > 0) {
                            $(document).trigger('cpet:refresh-table');
                        }
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: hasIssues ? 'warning' : 'success',
                                title: hasIssues ? 'Importación con observaciones' : 'Importación completada',
                                text: data.msj || '',
                                toast: !hasIssues,
                                position: hasIssues ? 'center' : 'top-end',
                                showConfirmButton: hasIssues,
                                timer: hasIssues ? undefined : 3200,
                                timerProgressBar: !hasIssues,
                                width: hasIssues ? '32rem' : undefined
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
                        btn.innerHTML = format === 'images'
                            ? '<i class="fas fa-upload mr-1"></i> Subir fotografías'
                            : '<i class="fas fa-upload mr-1"></i> Importar';
                    }
                });
        });
    });
});
</script>
