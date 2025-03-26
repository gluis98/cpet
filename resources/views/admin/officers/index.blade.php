@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('vendor/dropzone/dropzone.min.css')}}">
@endsection

@section('content')
{{-- INICIO MODALES --}}
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar Oficial</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add">
                <div class="aler alert-info p-2 border mb-3">
                    <p class="text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">
                        Datos personales
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="documento_identidad">Documento de identidad *</label>
                                <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required placeholder="Ingrese número de cédula">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="nombre_completo">Nombre Completo *</label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required placeholder="Ingrese el nombre completo">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento *</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="tipo_sangre">Tipo de sangre *</label>
                                <select class="form-control" id="tipo_sangre" name="tipo_sangre" required>
                                    <option value>--- SELECCIONE UN TIPO DE SANGRE ---</option>
                                    <option disabled class="text-secondary font-weight-bold">GRUPO A</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option disabled class="text-secondary font-weight-bold">GRUPO B</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option disabled class="text-secondary font-weight-bold">GRUPO AB</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option disabled class="text-secondary font-weight-bold">GRUPO O</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="estado_civil">Estado Civil</label>
                                <select class="form-control" id="estado_civil" name="estado_civil">
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Separado">Separado</option>
                                    <option value="Unión libre">Unión libre</option>
                                    <option value="Concubinato">Concubinato</option>
                                </select>
                            </div>
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="direccion">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" placeholder="Ingrese la dirección"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Datos de policiales
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="numero_placa">Número de credencial *</label>
                                <input type="text" class="form-control" id="numero_placa" name="numero_placa" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="fecha_ingreso">Fecha de ingreso *</label>
                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Estatus *</label>
                                <select class="form-control" id="estatus" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="card">
                    <div class="card-header">
                        Datos de vestuario
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="talla_camisa">Talla de camisa *</label>
                                <input type="text" class="form-control" id="talla_camisa" name="talla_camisa" required placeholder="Ingrese la talla de camisa">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="talla_pantalon">Talla de pantalón *</label>
                                <input type="text" class="form-control" id="talla_pantalon" name="talla_pantalon" required placeholder="Ingrese la talla de pantalón">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="talla_zapatos">Talla de zapatos *</label>
                                <input type="text" class="form-control" id="talla_zapatos" name="talla_zapatos" required placeholder="Ingrese la talla de zapato">
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="card">
                    <div class="card-header">
                        Datos de vestuario
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="telefono">Teléfono *</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="Ejemplo: +58 412 1234567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="correo_electronico">Correo Electrónico *</label>
                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required placeholder="Ingrese el correo electrónico">
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


  <!-- Modal Estudiante-->
<div class="modal fade" id="modal-archivos" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="width: 1000px !important; margin-left: -100px !important">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Archivos del oficial</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <p><i class="fas fa-info-circle"></i> En este apartado podrás subir todos los archivos del oficial y previsualizarlos</p>
            </div>
            <form class="dropzone" id="myDropzone" method="POST">
            </form>

            <hr>

            
            <div class="row" id="archivos-index">

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

{{-- FIN MODALES --}}

{{-- INICIO CONTENIDO PRINCIPAL --}}
<div class="row mb-3">
    <div class="col-md-12">
        <div class="au-breadcrumb-content justify-content-end">
            <a class="au-btn au-btn-icon au-btn--green" href="#" data-toggle="modal" data-target="#add" id="btn-add">
                <i class="zmdi zmdi-plus"></i>Agregar oficial
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <h2>{{$title}}</h2>
    <hr>
    <div class="responsive-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Cédula de identidad</th>
                    <th class="text-center" scope="col">Nombre completo</th>
                    <th class="text-center" scope="col">Teléfono</th>
                    <th class="text-center" scope="col">Número de placa</th>
                    <th class="text-center" scope="col">Fecha de ingreso</th>
                    <th class="text-center" scope="col">Estatus</th>
                    <th classs="actions" scope="col"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('vendor/dropzone/dropzone.min.js')}}"></script>
<script>
    Dropzone.autoDiscover = false;  // Deshabilita la detección automática de formularios
    $(document).ready(function() {
        var id = "";
        index();
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
            fetch('api/officers', {
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
            fetch('api/officers/'+id, {
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
            fetch('api/officers/'+id)
            .then(response => response.json())
            .then(data => {
                
                id = data.id;
                console.log(id)
                $('#documento_identidad').val(data.documento_identidad);
                $('#numero_placa').val(data.numero_placa);
                $('#fecha_nacimiento').val(data.fecha_nacimiento.substr(0,4) + '-' + data.fecha_nacimiento.substr(5,2) + '-' + data.fecha_nacimiento.substr(8,2));
                $('#nombre_completo').val(data.nombre_completo);
                $('#tipo_sangre option').each(function() {
                    if($(this).val() == data.tipo_sangre){
                        $(this).attr('selected', 'selected');
                    }
                });
                $('#direccion').val(data.direccion);
                $('#estado_civil option').each(function() {
                    if($(this).val() == data.estado_civil){
                        $(this).attr('selected', 'selected');
                    }
                });

                $('#numero_placa').val(data.numero_placa);
                $('#estatus option').each(function() {
                    if($(this).val() == data.estatus){
                        $(this).attr('selected', 'selected');
                    }
                });
                $('#fecha_ingreso').val(data.fecha_ingreso.substr(0,4) + '-' + data.fecha_ingreso.substr(5,2) + '-' + data.fecha_ingreso.substr(8,2));
                
                $('#talla_camisa').val(data.talla_camisa);
                $('#talla_pantalon').val(data.talla_pantalon);
                $('#talla_zapatos').val(data.talla_zapatos);
                $('#telefono').val(data.telefono);
                $('#correo_electronico').val(data.correo_electronico);

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
                                    fetch('/cpet/public/api/officers/'+id, {
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
                        fetch('/cpet/public/api/officers/'+id, {
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

        $(document).on('click','.delete-file', function(e){
            e.preventDefault();
            id = $(this).data('id');
            let formData = new FormData();
            formData.append('_method', 'DELETE');
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
                    fetch('api/officers/files/'+id, {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        Swal.fire(
                            'Eliminado!',
                            data.msj,
                            'success'
                        );
                        index_archivos();
                    });
                }
            });
        });

        $(document).on('click', '.files', function() {
            id = $(this).attr('data-id');
            // Note that the name "myDropzone" is the camelized

            if (!Dropzone.instances.length) { 
                const dropzone =  new Dropzone('#myDropzone', {
                    url: '/cpet/public/api/officers/files/add-files/'+id,  // URL donde se enviarán los archivos
                    method: 'POST', //Método por el cual se enviarán los archivos
                    paramName: 'archivos',          // El nombre del campo de archivo en el backend
                    maxFilesize: 2,             // Tamaño máximo en MB
                    acceptedFiles: '.jpg,.jpeg,.png',  // Tipos de archivo aceptados
                    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos',
                    success: function(file, response) {
                        index_archivos(id);
                    },
                    error: function(file, response) {
                        console.error("Error al subir archivo:", response);
                    }
                });
            }
            $('#modal-archivos').modal('show');
            index_archivos(id);
        })

        function index(){
            fetch('api/officers')
            .then(response => response.json())
            .then(data => {
                let template = '';
                data.forEach(e => {
                    template += `
                    <tr>
                        <td class="text-center">${e.documento_identidad}</td>
                        <td class="text-center">${e.nombre_completo}</td>
                        <td class="text-center">${e.telefono}</td>
                        <td class="text-center">${e.numero_placa}</td>
                        <td class="text-center">${e.fecha_ingreso.substr(0,4) + '-' + e.fecha_ingreso.substr(5,2) + '-' + e.fecha_ingreso.substr(8,2)}</td>
                        <td class="text-center">${e.estatus.toUpperCase()}</td>
                        <td class="text-right actions">
                            <button class="btn btn-dark edit" data-id="${e.id}"  data-toggle="tooltip" data-placement="top" title="Editar oficial"><i class="far fa-edit"></i></button>
                            <a href="officers/armament/${e.id}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Armamento"><i class="fas fa-shield-alt"></i></a>
                            <a href="officers/academy/${e.id}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Formación académica"><i class="fas fa-graduation-cap"></i></a>
                            <a href="officers/courses/${e.id}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Cursos y diplomados"><i class="fas fa-book-reader"></i></a>
                            <a href="officers/positions/${e.id}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Cargos alcanzados"><i class="fas fa-medal"></i></a>
                            <a href="officers/awards/${e.id}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Reconocimientos"><i class="fas fa-trophy"></i></a>
                            <a href="officers/familly/${e.id}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Hijos y familiares"><i class="fab fa-gratipay"></i></a>
                            <button data-id="${e.id}" class="btn btn-dark files" data-toggle="tooltip" data-placement="top" title="Archivos del oficial"><i class="fas fa-file"></i></button>
                            <a href="officers/vacations/${e.id}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Solicitud de vacaciones"><i class="fas fa-map-marked"></i></a>
                            <button class="btn btn-danger delete" data-id="${e.id}"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    `;
                });
                $('table').DataTable().destroy();
                $('tbody').html(template);
                $('table').DataTable(t);
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            });
        }

        function index_archivos(id){
            fetch('api/officers/files/index/' + id)
            .then(res => res.json())
            .then(data => {
                let template ="";

                if(data.length > 0){
                    data.forEach(element => {
                        template += `
                            <div class="col-12 col-md-4 mb-3">
                                <div class="img-container">
                                    <div class="position-relative">
                                        <a href="{{asset('storage')}}/${element.archivo_url}" download>
                                            <img src="{{asset('storage')}}/${element.archivo_url}" class="img-fluid border" alt="Previsualización">
                                        </a>
                                        <button class="btn btn-dark text-white position-absolute delete-file" style="top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;" data-id="${element.id}" title="Eliminar archivo"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }else{
                    template = `<div class='alert alert-light mx-auto'> <p>No hay archivos registrados de éste oficial.</p></div>`;
                }

                $('#archivos-index').html(template);
            });
        }
    });
    
</script>
@endsection