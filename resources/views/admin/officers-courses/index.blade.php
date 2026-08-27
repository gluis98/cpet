@extends('layouts.app')

@section('content')
{{-- INICIO MODALES --}}
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar curso o diplomado</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add">
                <div class="aler alert-info p-2 border mb-3">
                    <p class="text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">
                        Datos generales
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tipo">Tipo de formación *</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value>--- SELECCIONE UN TIPO ---</option>
                                    <option value="Curso">Curso</option>
                                    <option value="Diplomado">Diplomado</option>
                                    <option value="Taller">Taller</option>
                                </select>
                            </div>  
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="catalogo_curso_id">Nombre de curso/diplomado *</label>
                                <div class="input-group">
                                    <select class="form-control" id="catalogo_curso_id" name="catalogo_curso_id" required>
                                        <option value="">--- SELECCIONE ---</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="btn-add-curso" title="Agregar curso/diplomado">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Si no aparece en la lista, pulsa + para agregarlo.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="institucion">Institución</label>
                                <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese el nombre de la institución">
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="fecha_inicio">Fecha de curso o diplomado *</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="duracion_tipo">Tiempo de duración *</label>
                                <select class="form-control" id="duracion_tipo" name="duracion_tipo" required>
                                    <option value="">--- SELECCIONE ---</option>
                                    <option value="Años">Años</option>
                                    <option value="Meses">Meses</option>
                                    <option value="Horas">Horas</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="duracion_valor">Cantidad *</label>
                                <input type="number" class="form-control" id="duracion_valor" name="duracion_valor" min="1" max="9999" required placeholder="Ejemplo: 3">
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
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
                <i class="zmdi zmdi-plus"></i>Agregar curso - diplomado
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
        var apiBase = @json(url('api'));
        index();

        $(document).on('cpet:refresh-table', index);

        function loadCatalogoCursos(selectedId) {
            return CpetCatalog.loadSelect($('#catalogo_curso_id'), apiBase + '/catalogo-cursos', selectedId);
        }

        loadCatalogoCursos();

        $('#btn-add-curso').on('click', function () {
            CpetCatalog.promptAdd({
                title: 'Nuevo curso / diplomado',
                placeholder: 'Ejemplo: Criminalística y penalidad',
                postUrl: apiBase + '/catalogo-cursos',
                $select: $('#catalogo_curso_id'),
                successMessage: 'Curso/diplomado agregado',
            });
        });

        $('#btn-add').click(function(e){
            e.preventDefault();
            $('#form-edit').attr('id', 'form-add');
            $('#form-add').trigger('reset');
            loadCatalogoCursos();
            $('#btn-submit').text('Guardar');
            $('#btn-submit').attr('css', 'btn btn-primary btn-lg');
            $('#add').modal('show'); 
        });

        $(document).on('submit','#form-add', function(e){
            e.preventDefault();
            let formData = new FormData(this);
                formData.append('id_policia', '{{ $id }}');
            fetch(apiBase + '/officers/course', {
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
            fetch(apiBase + '/officers/course/'+id, {
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
            fetch('/cpet/public/api/officers/course/'+id)
            .then(response => response.json())
            .then(data => {
                
                id = data.id;
                
                $('#tipo option').each(function() {
                    if($(this).val() == data.tipo){
                        $(this).attr('selected', 'selected');
                    }
                });

                loadCatalogoCursos(data.catalogo_curso_id).then(function () {
                    $('#catalogo_curso_id').val(data.catalogo_curso_id || '');
                });
                $('#institucion').val(data.institucion);
                $('#fecha_inicio').val(data.fecha_inicio ? String(data.fecha_inicio).substr(0, 10) : '');
                $('#duracion_tipo').val(data.duracion_tipo || '');
                $('#duracion_valor').val(data.duracion_valor || '');
                $('#descripcion').val(data.descripcion);
                

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
                        request = fetch(apiBase + '/users/confirm-password-admin', {
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
                                    fetch(apiBase + '/officers/course/'+id, {
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
                        fetch(apiBase + '/officers/course/'+id, {
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
            fetch(apiBase + '/officers/course/index/{{ $id }}')
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
                
                    data.forEach(e => {
                        const nombreCurso = e.catalogo_curso?.nombre || e.nombre || 'Sin nombre';
                        template += `
                        <div class="row border p-3 mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 h4"><i class="fas fa-book-reader"></i> <span class="font-weight-bold">${nombreCurso}</span> - ${e.tipo}
                                        <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>    
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span>${new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(new Date(e.fecha_inicio))}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-muted">${e.institucion || 'Sin institución'}</span>
                                        ${e.duracion_valor && e.duracion_tipo ? '<span class="badge badge-secondary ml-2">Duración: ' + e.duracion_valor + ' ' + e.duracion_tipo + '</span>' : ''}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-justify">
                                            ${e.descripcion}
                                        </p>
                                    </div>
                                </div>
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