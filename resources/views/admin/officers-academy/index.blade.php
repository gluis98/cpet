@extends('layouts.app')

@section('content')
{{-- INICIO MODALES --}}
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar grado académico</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add" enctype="multipart/form-data">
                <div class="aler alert-info p-2 border mb-3">
                    <p class="text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">
                        Datos académicos
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tipo_formacion">Tipo de formación *</label>
                                <select class="form-control" id="tipo_formacion" name="tipo_formacion" required>
                                    <option value>--- SELECCIONE UN TIPO DE FORMACIÓN ---</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="Bachillerato">Bachillerato</option>
                                    <option value="Bachiller en Ciencias">Bachiller en Ciencias</option>
                                    <option value="Técnico superior universitario">Técnico superior universitario</option>
                                    <option value="Licenciatura">Licenciatura</option>
                                    <option value="Ingeniería">Ingeniería</option>
                                    <option value="Especialización">Especialización</option>
                                    <option value="Maestría">Maestría</option>
                                    <option value="Doctorado">Doctorado</option>
                                    <option value="Post-doctorado">Post-doctorado</option>
                                </select>
                            </div>  
                            <div class=" col-md-6">
                                <label class="form-label" for="titulo">Nombre de formación</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ejemplo: Informática Ó Ingeniería Informática">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="institucion">Institución</label>
                                <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese el nombre de la institución">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="anio_graduacion">Año de Graduación *</label>
                                <input type="number" class="form-control" id="anio_graduacion" name="anio_graduacion"
                                       min="1950" max="2100" step="1" required placeholder="Ejemplo: 2018">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="documento_fondo_negro">Documento (fondo negro)</label>
                                <input type="file" class="form-control-file" id="documento_fondo_negro" name="documento_fondo_negro" accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted">Formatos: JPG, PNG o PDF. Máximo 5 MB.</small>
                                <div id="documento-preview" class="mt-3" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="container-fluid d-grid gap-2 text-right">
                    <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                        <i class="fas fa-check-circle"></i>
                         Guardar
                    </button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


{{-- FIN MODALES --}}

{{-- INICIO CONTENIDO PRINCIPAL --}}
<div class="row mb-3">
    <div class="col-md-12">
        <div class="au-breadcrumb-content">
            <div class="au-breadcrumb-left">
                <a href="{{ route('officers') }}" class="btn text-uppercase text-dark"><i class="fas fa-arrow-left"></i> Regresar</a>
            </div>
            <a class="btn btn-dark btn-lg" href="#" data-toggle="modal" data-target="#add" id="btn-add">
                <i class="zmdi zmdi-plus"></i>Agregar grado académico
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <h2>{{$title}}</h2>
    <hr>
    <div class="container-fluid" id="academy-container">
        
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var id = "";
        var storageBase = @json(url('storage'));
        index();

        $(document).on('cpet:refresh-table', index);

        function renderDocumentPreview(url, isPdf) {
            if (!url) {
                $('#documento-preview').hide().html('');
                return;
            }
            let html = '';
            if (isPdf) {
                html = '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="fas fa-file-pdf"></i> Ver documento PDF</a>';
            } else {
                html = '<img src="' + url + '" alt="Documento fondo negro" class="img-thumbnail" style="max-height:220px;">';
            }
            $('#documento-preview').html(html).show();
        }

        function isPdfPath(path) {
            return /\.pdf$/i.test(path || '');
        }

        $('#documento_fondo_negro').on('change', function () {
            const file = this.files[0];
            if (!file) {
                return;
            }
            if (file.type === 'application/pdf') {
                renderDocumentPreview(URL.createObjectURL(file), true);
            } else {
                renderDocumentPreview(URL.createObjectURL(file), false);
            }
        });

        $('#btn-add').click(function(e){
            e.preventDefault();
            $('#form-edit').attr('id', 'form-add');
            $('#form-add').trigger('reset');
            renderDocumentPreview(null);
            $('#btn-submit').text('Guardar');
            $('#btn-submit').attr('css', 'btn btn-primary btn-lg');
            $('#add').modal('show'); 
        });

        $(document).on('submit','#form-add', function(e){
            e.preventDefault();
            let formData = new FormData(this);
                formData.append('id_policia', '{{ $id }}');
            fetch('{{ url("api/officers/academy") }}', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                CpetModule.afterSave({ message: data.msj, refresh: index });
            });
        });

        $(document).on('submit','#form-edit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
                formData.append('_method', 'PUT');
            console.log(id)
            fetch('{{ url("api/officers/academy") }}/'+id, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
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

        $(document).on('click','.edit', function(e){
            e.preventDefault();
            id = $(this).data('id');
            fetch('{{ url("api/officers/academy") }}/'+id)
            .then(response => response.json())
            .then(data => {
                
                id = data.id;
                
                $('#tipo_formacion option').each(function() {
                    if($(this).val() == data.tipo_formacion){
                        $(this).attr('selected', 'selected');
                    }
                });

                $('#titulo').val(data.titulo);
                $('#institucion').val(data.institucion);
                $('#anio_graduacion').val(data.fecha_fin ? String(data.fecha_fin).substr(0, 4) : '');
                $('#descripcion').val(data.descripcion);
                if (data.documento_fondo_negro_url) {
                    renderDocumentPreview(data.documento_fondo_negro_url, isPdfPath(data.documento_fondo_negro));
                } else {
                    renderDocumentPreview(null);
                }

                $('#form-add').attr('id', 'form-edit');
                $('#btn-submit').attr('class', 'btn btn-dark btn-lg');
                $('#btn-submit').text('Actualizar');
                $('#add').modal('show');
            });
        });

        $(document).on('click','.delete', function(e){
            e.preventDefault();
            id = $(this).data('id');
            let formData = new FormData();
            formData.append('_method', 'DELETE');
            let pass = "",
                request = "";
            if({{ auth()->user()->role != 'Administrador' ? 'true' : 'false' }}){
                Swal.fire({
                    title: 'Ingrese contraseña del administrador',
                    input: 'password',
                    inputPlaceholder: 'Contraseña actual',
                    inputAttributes: {
                        maxlength: 20,
                        autocapitalize: 'off',
                        autocorrect: 'off'
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        let form = new FormData();
                            form.append('password', result.value);
                        request = fetch('{{ url("api/users/confirm-password-admin") }}', {
                                        method: "POST",
                                        body: form
                                    }).then(response => response.json())
                                    .then(result => {
                                        return result;
                                    })
                                    .catch(error => {
                                        // Manejo de errores y asignar mensaje a una variable
                                        let errorMessage = `Error: ${error.message}`;
                                        console.error(errorMessage);
                                        return { error: errorMessage };
                                    });
                                    
                            return request;
                        
                    }
                }).then(() => {
                    request.then(result => {
                        if(result.msj){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.msj
                            });                            
                        }

                        if(result.status){
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "No podrás revertir esto.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    fetch('{{ url("api/officers/academy") }}/'+id, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            _method: 'DELETE',
                                            password: pass
                                        })
                                    }).then(response => response.json())
                                    .then(data => {
                                        CpetModule.afterSave({ message: data.msj, refresh: index });
                                    });
                                }
                            });
                        }

                        
                    });
                });
            }else{
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ url("api/officers/academy") }}/'+id, {
                            method: 'POST',
                            body: formData
                        }).then(response => response.json())
                        .then(data => {
                            CpetModule.afterSave({ message: data.msj, refresh: index });
                        });
                    }
                });
            }
        });

        function index(){
            fetch('{{ url("api/officers/academy/index/" . $id) }}')
            .then(response => response.json())
            .then(data => {
                let template = '';
                if(data.length == 0){
                    template += `
                        <div class="row border p-3">
                            <div class="col-md-12">
                                <h5 class="text-center text-muted">No hay datos registrados</h5>
                            </div>
                        </div>`;
                }else{
                
                    data.forEach((e, index) => {
                        const anio = e.fecha_fin ? String(e.fecha_fin).substr(0, 4) : 'S/F';
                        const esActual = index === 0 && e.fecha_fin;
                        template += `
                        <div class="row border p-3 mb-4 shadow ${esActual ? 'border-left border-warning' : ''}" style="${esActual ? 'border-left:4px solid #c4922e !important;' : ''}">
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-md-8 h4 mb-0">
                                        <span class="font-weight-bold">${e.titulo || e.tipo_formacion}</span>
                                        <span class="text-muted"> — ${e.tipo_formacion}</span>
                                        ${esActual ? '<span class="badge badge-warning ml-2" style="background:#c4922e;color:#1a1408;">Título Actual</span>' : ''}
                                        <button class="btn btn-dark btn-sm edit ml-2" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <span class="text-muted">Año de Graduación:</span>
                                        <strong>${anio}</strong>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <span class="text-muted">${e.institucion || 'Sin institución'}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-justify mb-0">
                                            ${((e.descripcion) ? e.descripcion : 'Sin descripción')}
                                        </p>
                                    </div>
                                </div>
                                ${e.documento_fondo_negro_url ? `
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <span class="text-muted d-block mb-2">Documento (fondo negro):</span>
                                        ${isPdfPath(e.documento_fondo_negro)
                                            ? '<a href="' + e.documento_fondo_negro_url + '" target="_blank" class="btn btn-sm btn-outline-dark"><i class="fas fa-file-pdf"></i> Ver PDF</a>'
                                            : '<a href="' + e.documento_fondo_negro_url + '" target="_blank"><img src="' + e.documento_fondo_negro_url + '" alt="Documento" class="img-thumbnail" style="max-height:180px;"></a>'}
                                    </div>
                                </div>` : ''}
                            </div>
                        </div>
                        `;
                    });
                }
                $('#academy-container').html(template);
            });
        }
    });
</script>
@endsection