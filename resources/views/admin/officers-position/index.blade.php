@extends('layouts.app')

@section('content')
{{-- INICIO MODALES --}}
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar cargo alcanzado</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add">
                <div class="aler alert-info p-2 border mb-3">
                    <p class="text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">
                        Datos del cargo
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="id_cargo">Cargo *</label>
                                <select class="form-control" id="id_cargo" name="id_cargo" required>

                                </select>
                            </div>  
                        </div>
                        <div class="row">
                            <div class=" col-md-6 mb-3">
                                <label class="form-label" for="fecha_inicio">Fecha de inicio *</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <div class=" col-md-6 mb-3">
                                <label class="form-label" for="fecha_fin">Fecha de fin</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_actual" name="is_actual" value="1">
                                    <label class="form-check-label" for="is_actual">Cargo actual</label>
                                </div>
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
                <i class="zmdi zmdi-plus"></i>Agregar cargo alcanzado
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
        index_cargos();

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
            fetch('/cpet/public/api/officers/position', {
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
            fetch('/cpet/public/api/officers/position/'+id, {
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
            fetch('/cpet/public/api/officers/position/'+id)
            .then(response => response.json())
            .then(data => {
                
                id = data.id;
                
                $('#id_cargo option').each(function() {
                    if($(this).val() == data.id_cargo){
                        $(this).attr('selected', 'selected');
                    }
                });

                $('#fecha_inicio').val(data.fecha_inicio.substr(0,4) + '-' + data.fecha_inicio.substr(5,2) + '-' + data.fecha_inicio.substr(8,2));

                if(data.fecha_fin){
                    $('#fecha_fin').val((!data.is_actual) ? data.fecha_fin.substr(0,4) + '-' + data.fecha_fin.substr(5,2) + '-' + data.fecha_fin.substr(8,2) : '');
                }
                $('#is_actual').prop('checked', data.is_actual == 1);
                

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
                                    fetch('/cpet/public/api/officers/position/'+id, {
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
                        fetch('/cpet/public/api/officers/position/'+id, {
                            method: 'DELETE',
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
            fetch('/cpet/public/api/officers/position/index/{{ $id }}')
            .then(response => response.json())
            .then(data => {
                let template = ''
                    actual = "";
                if(data.length == 0){
                    template += `
                        <div class="row border p-3">
                            <div class="col-md-12">
                                <h5 class="text-center text-muted">No hay datos registrados</h5>
                            </div>
                        </div>`;
                }else{
                    data.forEach(e => {
                        if(e.is_actual){
                            actual = "Cargo actual";
                        }
                        template += `
                        <div class="row border p-3 mb-2">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 h4"><span class="font-weight-bold"><i class="fas fa-medal ${(e.is_actual) ? "text-warning" : ""}"></i> ${e.cargo.nombre_cargo}</span> 
                                        <button class="btn btn-dark btn-sm edit" data-id="${e.id}"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete" data-id="${e.id}"><i class="fas fa-trash"></i></button>    
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span>${new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(new Date(e.fecha_inicio))}</span> - 
                                        <span>${new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' }).format(new Date(e.fecha_fin))}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-muted">${actual}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        actual = "";
                    });
                }
                $('#academy-container').html(template);
            });
        }

        function index_cargos(){
            fetch('/cpet/public/api/positions')
            .then(response => response.json())
            .then(data => {
                let template = '<option value>--- SELECCIONE UN CARGO ---</option>';
                data.forEach(e => {
                    template += `
                        <option value="${e.id}">${e.nombre_cargo}</option>
                    `;
                });
                $('#id_cargo').html(template);
            });
        }
    });
</script>
@endsection