@extends('layouts.app')

@section('content')
{{-- INICIO MODALES --}}
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar armamento</h4>
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
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="id_arma">Arma *</label>
                                <select class="form-control" id="id_arma" name="id_arma" required>
        
                                </select>
                            </div>  
                        </div>
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="fecha_asignacion">Fecha de asignación *</label>
                                <input type="date" class="form-control" id="fecha_asignacion" name="fecha_asignacion" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="estado">Estado *</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value>--- SELECCIONE UN ESTATUS ---</option>
                                    <option value="EXCELENTES CODICIONES">EXCELENTES CODICIONES</option>
                                    <option value="BUENO">BUENO</option>
                                    <option value="MEDIO">MEDIO</option>
                                    <option value="MAL ESTADO">MAL ESTADO</option>
                                </select>
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
            <a class="au-btn au-btn-icon au-btn--green" href="#" data-toggle="modal" data-target="#add" id="btn-add">
                <i class="zmdi zmdi-plus"></i>Agregar armamento
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
        index();
        index_armamento();

        $('#btn-add').click(function(e){
            e.preventDefault();
            $('#form-edit').attr('id', 'form-add');
            $('#form-add').trigger('reset');
            $('#btn-submit').text('Guardar');
            $('#btn-submit').attr('css', 'btn btn-primary btn-lg');
            $('#add').modal('show'); 
        });

        $(document).on('submit','#form-add', function(e){
            e.preventDefault();
            let formData = new FormData(this);
                formData.append('id_policia', '{{ $id }}');
            fetch('/cpet/public/api/officers/armament', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                $('#add').modal('hide');
                Swal.fire({
                    title: data.msj,
                    icon: "success",
                    draggable: true
                });
                index();
            });
        });

        $(document).on('submit','#form-edit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
                formData.append('_method', 'PUT');
            console.log(id)
            fetch('/cpet/public/api/officers/armament/'+id, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.msj,
                    icon: "success",
                    draggable: true
                });
                $('#add').modal('hide');
                $('#form-edit').trigger('reset');
                $('#form-edit').attr('id', 'form-add');
                id = "";
                index();
            });
        });

        $(document).on('click','.edit', function(e){
            e.preventDefault();
            id = $(this).data('id');
            fetch('/cpet/public/api/officers/armament/'+id)
            .then(response => response.json())
            .then(data => {
                
                id = data.id;
                
                $('#tipo option').each(function() {
                    if($(this).val() == data.tipo){
                        $(this).attr('selected', 'selected');
                    }
                });

                $('#nombre').val(data.nombre);
                $('#institucion').val(data.institucion);
                $('#fecha_inicio').val(data.fecha_inicio.substr(0,4) + '-' + data.fecha_inicio.substr(5,2) + '-' + data.fecha_inicio.substr(8,2));
                $('#fecha_fin').val(data.fecha_fin.substr(0,4) + '-' + data.fecha_fin.substr(5,2) + '-' + data.fecha_fin.substr(8,2));
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
                        request = fetch('/cpet/public/api/users/confirm-password-admin', {
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
                                    fetch('/cpet/public/api/officers/armament/'+id, {
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
                                        Swal.fire({
                                            title: data.msj,
                                            icon: "success",
                                            draggable: true
                                        });
                                        index();
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
                        fetch('/cpet/public/api/officers/armament/'+id, {
                            method: 'POST',
                            body: formData
                        }).then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                title: data.msj,
                                icon: "success",
                                draggable: true
                            });
                            index();
                        });
                    }
                });
            }
        });

        function index(){
            fetch('/cpet/public/api/officers/armament/index/{{ $id }}')
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
                        template += `
                        <div class="col-md-3">
                            <div class="card mb-3 shadow">
                                <div class="card-header">
                                    <i class="fas fa-shield-alt"></i> ${e.armamento.nombre}
                                    <span class="float-right">${e.armamento.tipo}</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><strong>Estado:</strong> ${e.estado}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><strong>Fecha de asignación:</strong> ${new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(new Date(e.fecha_asignacion))}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-justify">${e.descripcion}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>    
                                        </div>
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

        function index_armamento(){
            fetch('/cpet/public/api/armament')
            .then(response => response.json())
            .then(data => {
                let template = '<option value>--- SELECCIONE UN ARMAMENTO ---</option>';
                data.forEach(e => {
                    template += `
                        <option value="${e.id}">${e.nombre} - ${e.tipo} - ${e.calibre}</option>
                    `;
                });
                $('#id_arma').html(template);
            });
        }
    });
</script>
@endsection