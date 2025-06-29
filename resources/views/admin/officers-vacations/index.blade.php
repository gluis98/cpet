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
                        Datos de la solicitud
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="estatus">Estatus *</label>
                                <select class="form-control" id="estatus" name="estatus" required>
                                    <option value>--- SELECCIONE UN ESTATUS ---</option>
                                    <option value="APROBADAS">APROBADAS</option>
                                    <option value="NEGADAS">NEGADAS</option>
                                    <option value="VENCIDAS">VENCIDAS</option>
                                    <option value="REGLAMENTARIAS">REGLAMENTARIAS</option>
                                    <option value="EN PROCESO">EN PROCESO</option>
                                </select>
                            </div>  
                        </div>
                        <div class="row">
                            <div class=" col-md-6 mb-3">
                                <label class="form-label" for="fecha_emision">Fecha de emisión *</label>
                                <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" required>
                            </div>
                            <div class=" col-md-6 mb-3">
                                <label class="form-label" for="fecha_reintegro">Fecha de reintegro </label>
                                <input type="date" class="form-control" id="fecha_reintegro" name="fecha_reintegro">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_disfrutadas" name="is_disfrutadas" value="1">
                                    <label class="form-check-label" for="is_disfrutadas">¿Vacaciones disfrutadas?</label>
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
                <i class="zmdi zmdi-plus"></i>Agregar solicitud de vacaciones
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <h2>{{$title}}</h2>
    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-right">
                <p class="h5"><i class="fas fa-check text-success"></i> <b>Disfrutadas:</b> <span id="vacaciones-disfrutadas"></span></p>
                <p class="h5"><i class="fas fa-times text-danger"></i> <b>Vencidas:</b> <span id="vacaciones-vencidas"></span></p>
            </div>
        </div>
    </div>
    <div class="responsive-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Fecha de emisión</th>
                    <th class="text-center" scope="col">Fecha de reintegro</th>
                    <th class="text-center" scope="col">¿Disfrutadas?</th>
                    <th class="text-center" scope="col">Estatus</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var id = "";
        index(); 

        // Run the function on page load
        toggleCheckbox();

        // Run the function whenever the select value changes
        $('#estatus').on('change', toggleCheckbox);

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
            fetch('/cpet/public/api/officers/vacations', {
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
            fetch('/cpet/public/api/officers/vacations/'+id, {
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
            fetch('/cpet/public/api/officers/vacations/'+id)
            .then(response => response.json())
            .then(data => {
                
                id = data.id;
                $('#fecha_emision').val(data.fecha_emision.substr(0,4) + '-' + data.fecha_emision.substr(5,2) + '-' + data.fecha_emision.substr(8,2));
                $('#fecha_reintegro').val(data.fecha_reintegro.substr(0,4) + '-' + data.fecha_reintegro.substr(5,2) + '-' + data.fecha_reintegro.substr(8,2));
                $('#descripcion').val(data.descripcion);

                $('#is_disfrutadas').prop('checked', data.is_disfrutadas == 1);
                $('#estatus option').each(function() {
                    if($(this).val() == data.estatus){
                        $(this).attr('selected', 'selected');
                        $('#estatus').trigger('change');
                    }
                });

                

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
                                    fetch('/cpet/public/api/officers/vacations/'+id, {
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
                        fetch('/cpet/public/api/officers/vacations/'+id, {
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
            fetch('/cpet/public/api/officers/vacations/index/{{ $id }}')
            .then(response => response.json())
            .then(data => {
                let template = '', 
                    disfrutadas = 0,
                    vencidas = 0;
                data.forEach(e => {
                    if(e.is_disfrutadas){
                        disfrutadas++;
                    }

                    if(e.estatus == 'Vencidas'){
                        vencidas++;
                    }

                    template += `
                    <tr>
                        <td class="text-center">${e.fecha_emision.substr(0,4) + '-' + e.fecha_emision.substr(5,2) + '-' + e.fecha_emision.substr(8,2)}</td>
                        <td class="text-center">${e.fecha_reintegro.substr(0,4) + '-' + e.fecha_reintegro.substr(5,2) + '-' + e.fecha_reintegro.substr(8,2)}</td>
                        <td class="text-center">${(e.is_disfrutadas) ? "Disfrutadas" : 'Sin disfrutar'}</td>
                        <td class="text-center">${e.estatus}</td>
                        <td class="text-right">
                            <a href="../../reports/vacation/${e.id}" target="_blank" class="btn btn-dark"><i class="fas fa-print"></i></a>
                            <button class="btn btn-dark edit" data-id="${e.id}"><i class="far fa-edit"></i></button>
                            <button class="btn btn-danger delete" data-id="${e.id}"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    `;
                });
                $('#vacaciones-disfrutadas').html(disfrutadas);
                $('#vacaciones-vencidas').html(vencidas);

                $('table').DataTable().destroy();
                $('tbody').html(template);
                $('table').DataTable(t);
            });
        }

        function toggleCheckbox() {
            const status = $('#estatus').val();
            if (status === 'APROBADAS') {
                $('#is_disfrutadas').prop('disabled', false);
            } else {
                $('#is_disfrutadas').prop('disabled', true).prop('checked', false); // Disable and uncheck
            }
        }
    });
</script>
@endsection