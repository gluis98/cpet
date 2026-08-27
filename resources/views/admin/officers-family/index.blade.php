@extends('layouts.app')

@section('content')
{{-- INICIO MODALES --}}
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar familiar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add" enctype="multipart/form-data">
                <div class="alert alert-info p-2 border mb-3">
                    <p class="mb-0 text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">Datos del familiar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="parentesco">Parentesco *</label>
                                <select class="form-control" id="parentesco" name="parentesco" required>
                                    <option value="">--- SELECCIONE UN PARENTESCO ---</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Hijo(a)">Hijo(a)</option>
                                    <option value="Esposo(a)">Esposo(a)</option>
                                    <option value="Conyugue">Conyugue</option>
                                    <option value="Union Estable de Hechos">Union Estable de Hechos</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="nombre_completo">Nombre completo *</label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento *</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="sexo">Sexo *</label>
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="">--- SELECCIONE UN SEXO ---</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="edad">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad" min="0" max="120">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="direccion">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion"></textarea>
                            </div>
                        </div>

                        <hr>
                        <h6 class="font-weight-bold mb-3">Discapacidad</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="posee_discapacidad">¿Posee discapacidad? *</label>
                                <select class="form-control" id="posee_discapacidad" name="posee_discapacidad" required>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3" id="discapacidad-wrap" style="display:none;">
                                <label class="form-label" for="discapacidad_id">Tipo de discapacidad</label>
                                <div class="input-group">
                                    <select class="form-control" id="discapacidad_id" name="discapacidad_id">
                                        <option value="">--- SELECCIONE ---</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="btn-add-discapacidad" title="Agregar tipo">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Si no aparece en la lista, pulsa + para agregarla.</small>
                            </div>
                        </div>
                        <div id="discapacidad-detalles" style="display:none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="discapacidad_requerimientos">Requerimientos (medicinas, apoyos, etc.)</label>
                                    <textarea class="form-control" id="discapacidad_requerimientos" name="discapacidad_requerimientos" rows="2" placeholder="Ejemplo: Insulina, silla de ruedas…"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="discapacidad_observaciones">Observaciones</label>
                                    <textarea class="form-control" id="discapacidad_observaciones" name="discapacidad_observaciones" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="informe_medico">Informe médico / documento que compruebe la discapacidad</label>
                                    <input type="file" class="form-control-file" id="informe_medico" name="informe_medico" accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="text-muted">Formatos: JPG, PNG o PDF. Máximo 5 MB.</small>
                                    <div id="informe-preview" class="mt-2" style="display:none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="container-fluid text-right">
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
{{-- FIN MODALES --}}

<div class="row mb-3">
    <div class="col-md-12">
        <div class="au-breadcrumb-content">
            <div class="au-breadcrumb-left">
                <a href="{{ route('officers') }}" class="btn text-uppercase text-dark"><i class="fas fa-arrow-left"></i> Regresar</a>
            </div>
            <a class="btn btn-dark btn-lg" href="#" data-toggle="modal" data-target="#add" id="btn-add">
                <i class="zmdi zmdi-plus"></i> Agregar familiar
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <h2>{{ $title }}</h2>
    <hr>
    <div class="responsive-table">
        <table class="table table-bordered" id="familiares-table">
            <thead>
                <tr>
                    <th class="text-center">Nombre completo</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Parentesco</th>
                    <th class="text-center">Fecha de nacimiento</th>
                    <th class="text-center">Edad</th>
                    <th class="text-center">Dirección</th>
                    <th class="text-center">Sexo</th>
                    <th class="text-center">Discapacidad</th>
                    <th scope="col"></th>
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
        var dtEs = {
            decimal: ',', thousands: '.', processing: 'Procesando...', search: 'Buscar:',
            lengthMenu: 'Mostrar _MENU_ registros',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 a 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            loadingRecords: 'Cargando...', zeroRecords: 'No se encontraron resultados',
            emptyTable: 'No hay datos disponibles',
            paginate: { first: 'Primero', previous: 'Anterior', next: 'Siguiente', last: 'Último' }
        };

        loadDiscapacidades();
        index();

        $(document).on('cpet:refresh-table', index);

        function syncDiscapacidadUI() {
            var show = $('#posee_discapacidad').val() === '1';
            $('#discapacidad-wrap').toggle(show);
            $('#discapacidad-detalles').toggle(show);
            if (!show) {
                $('#discapacidad_id').val('');
                $('#discapacidad_requerimientos').val('');
                $('#discapacidad_observaciones').val('');
                renderInformePreview(null);
            }
        }

        function renderInformePreview(url, isPdf) {
            if (!url) {
                $('#informe-preview').hide().html('');
                return;
            }
            let html = isPdf
                ? '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="fas fa-file-pdf"></i> Ver informe PDF</a>'
                : '<a href="' + url + '" target="_blank"><img src="' + url + '" alt="Informe médico" class="img-thumbnail" style="max-height:160px;"></a>';
            $('#informe-preview').html(html).show();
        }

        function isPdfPath(path) {
            return /\.pdf$/i.test(path || '');
        }

        $('#informe_medico').on('change', function () {
            const file = this.files[0];
            if (!file) return;
            renderInformePreview(URL.createObjectURL(file), file.type === 'application/pdf');
        });

        $('#posee_discapacidad').on('change', syncDiscapacidadUI);

        function loadDiscapacidades(selectedId) {
            return CpetCatalog.loadSelect($('#discapacidad_id'), apiBase + '/discapacidades', selectedId);
        }

        $('#btn-add-discapacidad').on('click', function () {
            CpetCatalog.promptAdd({
                title: 'Nueva discapacidad',
                placeholder: 'Ejemplo: Visual, Motora…',
                postUrl: apiBase + '/discapacidades',
                $select: $('#discapacidad_id'),
                successMessage: 'Discapacidad agregada',
                onAdded: function () {
                    $('#posee_discapacidad').val('1');
                    syncDiscapacidadUI();
                },
            });
        });

        $('#btn-add').click(function (e) {
            e.preventDefault();
            $('#form-edit').attr('id', 'form-add');
            $('#form-add').trigger('reset');
            $('#posee_discapacidad').val('0');
            syncDiscapacidadUI();
            renderInformePreview(null);
            $('#btn-submit').text('Guardar').attr('class', 'btn btn-primary btn-lg');
            $('#add').modal('show');
        });

        $(document).on('submit', '#form-add', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('id_policia', '{{ $id }}');
            if ($('#posee_discapacidad').val() !== '1') {
                formData.set('discapacidad_id', '');
            }
            fetch(apiBase + '/officers/familly', { method: 'POST', body: formData })
                .then(async r => {
                    const data = await r.json();
                    if (!r.ok) throw data;
                    return data;
                })
                .then(data => {
                    CpetModule.afterSave({ message: data.msj, refresh: index });
                })
                .catch(err => {
                    const msg = err?.errors ? Object.values(err.errors).flat().join('\n') : (err.message || 'Error al guardar');
                    Swal.fire({ icon: 'error', title: 'Revisa el formulario', text: msg });
                });
        });

        $(document).on('submit', '#form-edit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('_method', 'PUT');
            if ($('#posee_discapacidad').val() !== '1') {
                formData.set('discapacidad_id', '');
            }
            fetch(apiBase + '/officers/familly/' + id, { method: 'POST', body: formData })
                .then(async r => {
                    const data = await r.json();
                    if (!r.ok) throw data;
                    return data;
                })
                .then(data => {
                    CpetModule.afterSave({
                        message: data.msj,
                        refresh: index,
                        onReset: function () {
                            $('#form-edit').trigger('reset').attr('id', 'form-add');
                            id = '';
                        }
                    });
                })
                .catch(err => {
                    const msg = err?.errors ? Object.values(err.errors).flat().join('\n') : (err.message || 'Error al actualizar');
                    Swal.fire({ icon: 'error', title: 'Revisa el formulario', text: msg });
                });
        });

        $(document).on('click', '.edit', function (e) {
            e.preventDefault();
            id = $(this).data('id');
            fetch(apiBase + '/officers/familly/' + id)
                .then(r => r.json())
                .then(data => {
                    id = data.id;
                    $('#fecha_nacimiento').val(data.fecha_nacimiento ? String(data.fecha_nacimiento).substr(0, 10) : '');
                    $('#telefono').val(data.telefono || '');
                    $('#direccion').val(data.direccion || '');
                    $('#nombre_completo').val(data.nombre_completo || '');
                    $('#edad').val(data.edad || '');
                    $('#parentesco').val(data.parentesco || '');
                    $('#sexo').val(data.sexo || '');
                    $('#posee_discapacidad').val(data.posee_discapacidad ? '1' : '0');
                    $('#discapacidad_requerimientos').val(data.discapacidad_requerimientos || '');
                    $('#discapacidad_observaciones').val(data.discapacidad_observaciones || '');
                    loadDiscapacidades(data.discapacidad_id).then(function () {
                        syncDiscapacidadUI();
                        if (data.informe_medico_url) {
                            renderInformePreview(data.informe_medico_url, isPdfPath(data.informe_medico));
                        } else {
                            renderInformePreview(null);
                        }
                    });
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
                fetch(apiBase + '/officers/familly/' + id, { method: 'POST', body: formData })
                    .then(r => r.json())
                    .then(data => {
                        CpetModule.afterSave({ message: data.msj, refresh: index });
                    });
            });
        });

        function index() {
            fetch(apiBase + '/officers/familly/index/{{ $id }}')
                .then(r => r.json())
                .then(data => {
                    let template = '';
                    (data || []).forEach(e => {
                        const disc = e.posee_discapacidad
                            ? (e.discapacidade?.nombre || 'Sí (sin tipo)')
                            : 'No';
                        const discDetalle = e.posee_discapacidad && (e.discapacidad_requerimientos || e.discapacidad_observaciones)
                            ? '<br><small class="text-muted">' + (e.discapacidad_requerimientos ? 'Req: ' + e.discapacidad_requerimientos : '') + (e.discapacidad_observaciones ? ' · Obs: ' + e.discapacidad_observaciones : '') + '</small>'
                            : '';
                        const informeBtn = e.informe_medico_url
                            ? '<br><a href="' + e.informe_medico_url + '" target="_blank" class="btn btn-xs btn-outline-dark btn-sm mt-1"><i class="fas fa-file-medical"></i> Informe</a>'
                            : '';
                        const fecha = e.fecha_nacimiento ? String(e.fecha_nacimiento).substr(0, 10) : 'S/F';
                        template += `
                        <tr>
                            <td class="text-center">${e.nombre_completo}</td>
                            <td class="text-center">${e.telefono || 'S/N'}</td>
                            <td class="text-center">${e.parentesco}</td>
                            <td class="text-center">${fecha}</td>
                            <td class="text-center">${e.edad != null ? e.edad : 'S/E'}</td>
                            <td class="text-center">${e.direccion || 'S/D'}</td>
                            <td class="text-center">${e.sexo === 'M' ? 'Masculino' : (e.sexo === 'F' ? 'Femenino' : 'S/S')}</td>
                            <td class="text-center">${disc}${discDetalle}${informeBtn}</td>
                            <td class="text-right">
                                <button class="btn btn-dark edit" data-id="${e.id}"><i class="far fa-edit"></i></button>
                                <button class="btn btn-danger delete" data-id="${e.id}"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>`;
                    });
                    CpetModule.refreshDataTable('#familiares-table', template || '<tr><td colspan="9" class="text-center text-muted">Sin familiares registrados</td></tr>', {
                        order: [[0, 'asc']]
                    });
                });
        }
    });
</script>
@endsection
