@extends('layouts.app')

@section('styles')
<style>
    .officer-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.65rem 1rem;
        border: 0;
        border-radius: 0.75rem 0.75rem 0 0;
        background: transparent;
        color: #64748b;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: color 0.15s, background 0.15s, box-shadow 0.15s;
    }

    .officer-tab i {
        font-size: 0.8rem;
        opacity: 0.85;
    }

    .officer-tab:hover {
        color: #1a4574;
        background: rgba(255, 255, 255, 0.7);
    }

    .officer-tab.is-active {
        color: #0f2744;
        background: #fff;
        box-shadow: 0 -1px 0 #fff, 0 1px 0 #fff;
        position: relative;
    }

    .officer-tab.is-active::after {
        content: "";
        position: absolute;
        left: 0.75rem;
        right: 0.75rem;
        bottom: 0;
        height: 3px;
        border-radius: 999px;
        background: linear-gradient(90deg, #c4922e, #d4a84b);
    }

    .photo-dropzone {
        display: block !important;
        margin-left: auto !important;
        margin-right: auto !important;
        margin-bottom: 0 !important;
    }

    .photo-dropzone .photo-placeholder {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        position: absolute !important;
        inset: 0 !important;
        margin: 0 !important;
    }

    .photo-dropzone .photo-placeholder.hidden {
        display: none !important;
    }

    .photo-dropzone.is-dragover {
        border-color: #2f6fad !important;
        background: linear-gradient(180deg, #eef4fb, #fff) !important;
        transform: scale(1.01);
        box-shadow: 0 0 0 4px rgba(47, 111, 173, 0.15);
    }

    .officer-form .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #1a4574;
        margin-bottom: 0.35rem;
    }

    @media (max-width: 640px) {
        .officer-tab span {
            display: none;
        }

        .officer-tab {
            padding: 0.7rem 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div>
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">Funcionarios</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="mt-1 text-sm text-slate-500">Completa cada pestaña y carga la fotografía del funcionario</p>
        </div>
        <a href="{{ route('officers.tipo', $tipo) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $oficial->exists ? route('officers.form.update', [$tipo, $oficial->id]) : route('officers.form.store', $tipo) }}"
          enctype="multipart/form-data"
          id="officer-form">
        @csrf
        @if ($oficial->exists)
            @method('PUT')
        @endif

        @include('admin.officers._form')
    </form>
</div>
@endsection

@section('scripts')
<script>
(function () {
    // Tabs
    var tabs = document.querySelectorAll('.officer-tab');
    var panes = document.querySelectorAll('.officer-pane');

    function activateTab(name) {
        tabs.forEach(function (tab) {
            var active = tab.getAttribute('data-tab') === name;
            tab.classList.toggle('is-active', active);
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        panes.forEach(function (pane) {
            var match = pane.id === 'pane-' + name;
            pane.classList.toggle('hidden', !match);
            if (match) {
                pane.removeAttribute('hidden');
            } else {
                pane.setAttribute('hidden', 'hidden');
            }
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            activateTab(tab.getAttribute('data-tab'));
        });
    });

    // Si hay errores de validación, abrir la pestaña del primer campo inválido
    var firstInvalid = document.querySelector('.officer-pane .is-invalid, .officer-pane :invalid');
    if (firstInvalid) {
        var pane = firstInvalid.closest('.officer-pane');
        if (pane) {
            activateTab(pane.id.replace('pane-', ''));
        }
    }

    // Foto
    var input = document.getElementById('fotografia');
    var dropzone = document.getElementById('photo-dropzone');
    var preview = document.getElementById('photo-preview');
    var placeholder = document.getElementById('photo-placeholder');
    var overlay = document.getElementById('photo-overlay');
    var filenameEl = document.getElementById('photo-filename');
    var clearBtn = document.getElementById('photo-clear');
    var objectUrl = null;
    var hadExisting = {{ ($oficial->exists && $oficial->fotografia) ? 'true' : 'false' }};
    var existingUrl = @json(($oficial->exists && $oficial->fotografia) ? asset('storage/'.$oficial->fotografia) : null);

    function showPreview(url, label) {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        preview.src = url;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        filenameEl.textContent = label || 'Imagen seleccionada';
        clearBtn.classList.remove('hidden');
    }

    function resetPreview() {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        input.value = '';
        if (hadExisting && existingUrl) {
            showPreview(existingUrl, 'Foto actual cargada');
            return;
        }
        preview.removeAttribute('src');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        filenameEl.textContent = 'Sin imagen seleccionada';
        clearBtn.classList.add('hidden');
    }

    function handleFile(file) {
        if (!file) return;
        if (!file.type.match(/^image\//)) {
            if (window.Swal) {
                Swal.fire({ icon: 'warning', title: 'Archivo no válido', text: 'Selecciona una imagen (JPG, PNG, etc.).' });
            } else {
                alert('Selecciona una imagen válida.');
            }
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            if (window.Swal) {
                Swal.fire({ icon: 'warning', title: 'Archivo muy grande', text: 'El tamaño máximo es 5 MB.' });
            } else {
                alert('El tamaño máximo es 5 MB.');
            }
            return;
        }
        objectUrl = URL.createObjectURL(file);
        showPreview(objectUrl, file.name);
    }

    input.addEventListener('change', function () {
        handleFile(input.files && input.files[0]);
    });

    ['dragenter', 'dragover'].forEach(function (evt) {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('is-dragover');
        });
    });

    ['dragleave', 'drop'].forEach(function (evt) {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('is-dragover');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        var file = e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0];
        if (!file) return;
        var dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        handleFile(file);
    });

    clearBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        // Si había foto previa y limpian la nueva selección, vuelven a la existente
        if (input.files && input.files.length) {
            resetPreview();
            return;
        }
        resetPreview();
    });

    // Al guardar, si falla un required oculto, abrir su pestaña
    var form = document.getElementById('officer-form');
    form.addEventListener('submit', function (e) {
        var invalid = form.querySelector(':invalid');
        if (invalid) {
            var pane = invalid.closest('.officer-pane');
            if (pane) {
                activateTab(pane.id.replace('pane-', ''));
                setTimeout(function () { invalid.focus(); }, 50);
            }
        }
    });

    // Vivienda: mostrar/ocultar dirección
    var tipoVivienda = document.getElementById('tipo_vivienda');
    var dirWrap = document.getElementById('direccion-vivienda-wrap');
    var dirInput = document.getElementById('direccion_vivienda');

    function syncVivienda() {
        var val = tipoVivienda ? tipoVivienda.value : '';
        var show = val === 'Propia' || val === 'Alquilada';
        if (dirWrap) {
            dirWrap.style.display = show ? '' : 'none';
        }
        if (!show && dirInput) {
            dirInput.value = '';
        }
    }

    tipoVivienda?.addEventListener('change', syncVivienda);
    syncVivienda();

    // Conducción: mostrar/ocultar tipos de vehículo
    var sabeConducir = document.getElementById('sabe_conducir');
    var tiposWrap = document.getElementById('tipos-conduccion-wrap');

    function syncConduccion() {
        var show = sabeConducir && sabeConducir.value === '1';
        if (tiposWrap) {
            tiposWrap.style.display = show ? '' : 'none';
        }
        if (!show && tiposWrap) {
            tiposWrap.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
                cb.checked = false;
            });
        }
    }

    sabeConducir?.addEventListener('change', syncConduccion);
    syncConduccion();

    // Catálogos: agregar cargo / tipo de cargo desde el select
    if (window.CpetCatalog && window.jQuery) {
        var apiBase = @json(url('api'));

        $('#btn-add-cargo-admin').on('click', function () {
            CpetCatalog.promptAdd({
                title: 'Nuevo cargo',
                placeholder: 'Ejemplo: Asistente administrativo…',
                postUrl: apiBase + '/cargos-administrativos',
                $select: $('#cargo_administrativo_id'),
                successMessage: 'Cargo agregado',
            });
        });

        var estadoTrujilloId = @json(\App\Models\Municipio::ESTADO_TRUJILLO_ID);
        var selectedMunicipioId = @json(old('municipio_id', optional($oficial->parroquia)->municipio_id));
        var selectedParroquiaId = @json(old('parroquia_id', $oficial->parroquia_id));

        function loadParroquias(municipioId, selectedId) {
            if (!municipioId) {
                $('#parroquia_id').html($('<option>', { value: '', text: '--- SELECCIONE ---' }));
                return $.when();
            }
            return CpetCatalog.loadSelect(
                $('#parroquia_id'),
                apiBase + '/parroquias?municipio_id=' + encodeURIComponent(municipioId),
                selectedId
            );
        }

        CpetCatalog.loadSelect(
            $('#municipio_id'),
            apiBase + '/municipios?estado_id=' + estadoTrujilloId,
            selectedMunicipioId
        ).then(function () {
            if (selectedMunicipioId) {
                loadParroquias(selectedMunicipioId, selectedParroquiaId);
            }
        });

        $('#municipio_id').on('change', function () {
            loadParroquias($(this).val(), null);
        });

        $('#btn-add-municipio').on('click', function () {
            CpetCatalog.promptAdd({
                title: 'Nuevo municipio',
                placeholder: 'Ejemplo: Valera…',
                postUrl: apiBase + '/municipios',
                fieldName: 'descripcion',
                $select: $('#municipio_id'),
                extraFormData: { estado_id: estadoTrujilloId },
                successMessage: 'Municipio agregado',
                onAdded: function () {
                    $('#parroquia_id').html($('<option>', { value: '', text: '--- SELECCIONE ---' }));
                },
            });
        });

        $('#btn-add-parroquia').on('click', function () {
            var municipioId = $('#municipio_id').val();
            if (!municipioId) {
                Swal.fire({ icon: 'warning', title: 'Seleccione un municipio primero' });
                return;
            }
            CpetCatalog.promptAdd({
                title: 'Nueva parroquia',
                placeholder: 'Ejemplo: La Beatriz…',
                postUrl: apiBase + '/parroquias',
                fieldName: 'descripcion',
                $select: $('#parroquia_id'),
                extraFormData: { municipio_id: municipioId },
                successMessage: 'Parroquia agregada',
            });
        });
    }
})();
</script>
@endsection
