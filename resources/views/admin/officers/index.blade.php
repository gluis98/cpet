@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('vendor/dropzone/dropzone.min.css')}}">
<style>
    .ficha-container {
            width: 100%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: 2px solid #007bff;
        }
        .ficha-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        .ficha-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .ficha-photo {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
        }
        .ficha-body {
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .section-title {
            grid-column: span 2;
            background: #e7f1ff;
            color: #004085;
            padding: 10px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }
        .data-field {
            display: flex;
            flex-direction: column;
        }
        .data-field label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        .data-field span {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 6px;
            font-size: 16px;
            color: #555;
            margin-top: 5px;
        }
        .full-width {
            grid-column: span 2;
        }
        .ficha-footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #e0e0e0;
        }
</style>
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
                                <select class="form-control" id="tipo_sangre" name="tipo_sangre">
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
                                <select class="form-control" id="estatus" required name="estatus">
                                    <option value="Operativo">Operativo</option>
                                    <option value="No Operativo">No Operativo</option>
                                    <option value="Retirado">Retirado</option>
                                    <option value="Suspendido">Suspendido</option>
                                    <option value="Jubilado">Jubilado</option>
                                    <option value="Fallecido">Fallecido</option>
                                    <option value="URRA">URRA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-label">Cargo administrativo *</label>
                            <select class="form-control" id="cargo_administrativo_id" name="cargo_administrativo_id" required>
                                <option value>--- SELECCIONE UN CARGO ADMINISTRATIVO ---</option>
                                @foreach(\App\Models\CargosAdministrativo::orderBy('nombre_cargo', 'ASC')->get() as $ca)
                                    <option value="{{$ca->id}}">{{$ca->nombre_cargo}}</option>
                                @endforeach
                            </select>
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
                                <input type="text" class="form-control" id="talla_camisa" name="talla_camisa" placeholder="Ingrese la talla de camisa">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="talla_pantalon">Talla de pantalón *</label>
                                <input type="text" class="form-control" id="talla_pantalon" name="talla_pantalon" placeholder="Ingrese la talla de pantalón">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="talla_zapatos">Talla de zapatos *</label>
                                <input type="text" class="form-control" id="talla_zapatos" name="talla_zapatos" placeholder="Ingrese la talla de zapato">
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
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ejemplo: +58 412 1234567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="correo_electronico">Correo Electrónico *</label>
                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" placeholder="Ingrese el correo electrónico">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        Fotografía
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="fotografia">Seleccione una fotografía para el oficial</label>
                                <input type="file" class="form-control" id="fotografia" name="fotografia">
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

 <!-- Modal -->
<div class="modal fade" id="modal-ficha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="ficha-container">
                <div class="ficha-header">
                    <h2 class="text-white h1"><i class="fas fa-user-shield"></i> Ficha del Oficial</h2>
                    <img src="" alt="Foto del oficial" class="ficha-photo bg-white" id="foto-oficial">
                </div>
                <div class="ficha-body">
                    <!-- Datos Personales -->
                    <div class="section-title"><i class="fas fa-user"></i> Datos Personales</div>
                    <div class="data-field">
                        <label>Cédula</label>
                        <span id="documento_identidad_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Nombre Completo</label>
                        <span id="nombre_completo_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Fecha de Nacimiento</label>
                        <span id="fecha_nacimiento_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Edad</label>
                        <span id="edad_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Tipo de Sangre</label>
                        <span id="tipo_sangre_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Estado Civil</label>
                        <span id="estado_civil_ficha">N/A</span>
                    </div>
                    <div class="data-field full-width">
                        <label>Dirección</label>
                        <span id="direccion_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Teléfono</label>
                        <span id="telefono_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Correo Electrónico</label>
                        <span id="correo_electronico_ficha">N/A</span>
                    </div>
                    <div class="data-field full-width">
                        <label>Centro de Votación</label>
                        <span id="centro_votacion_ficha">N/A</span>
                    </div>
                    <!-- Datos Policiales -->
                    <div class="section-title"><i class="fas fa-shield-alt"></i> Datos Policiales</div>
                    <div class="data-field">
                        <label>Número de Credencial</label>
                        <span id="numero_placa_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Fecha de Ingreso</label>
                        <span id="fecha_ingreso_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Estatus</label>
                        <span id="estatus_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Jerarquía Actual</label>
                        <span id="cargo_actual_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Cargo Actual</label>
                        <span id="cargo_administrativo_actual_ficha">N/A</span>
                    </div>
                
                    <!-- Datos de Vestuario -->
                    <div class="section-title"><i class="fas fa-tshirt"></i> Datos de Vestuario</div>
                    <div class="data-field">
                        <label>Talla de Camisa</label>
                        <span id="talla_camisa_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Talla de Pantalón</label>
                        <span id="talla_pantalon_ficha">N/A</span>
                    </div>
                    <div class="data-field">
                        <label>Talla de Zapatos</label>
                        <span id="talla_zapatos_ficha">N/A</span>
                    </div>
                </div>
                <div class="ficha-footer">
                    Generado el 18 de junio de 2025 | Sistema de Gestión Policial xAI
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="printFicha()">Imprimir Ficha</button>
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
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
            <a class="btn btn-dark btn-lg" href="#" data-toggle="modal" data-target="#add" id="btn-add">
                <i class="zmdi zmdi-plus"></i>Agregar oficial
            </a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <h2>{{$title}}</h2>
    <hr>
    <table class="table table-bordered" id="officers-table">
        <thead>
            <tr>
                <th class="text-center" scope="col">N° Credencial</th>
                <th class="text-center" scope="col">N° de Cédula</th>
                <th class="text-center" scope="col">Nombre y apellido</th>
                <th class="text-center" scope="col">Teléfono</th>
                <th class="text-center" scope="col">Fecha de ingreso</th>
                <th class="text-center" scope="col">Jerarquía</th>
                <th class="text-center" scope="col">Cargo</th>
                <th class="text-center" scope="col">Estatus</th>
                <th classs="actions" scope="col"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
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

                $('#cargo_administrativo_id option').each(function() {
                    if($(this).val() == data.cargo_administrativo_id){
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

        $(document).on('click', '.ficha', function(e) {
            e.preventDefault();
            id = $(this).data('id');
            fetch('api/officers/' + id)
                .then(response => response.json())
                .then(data => {
                    // Calcular edad
                    let edad = 'N/A';
                    if (data.fecha_nacimiento) {
                        const hoy = new Date();
                        const nacimiento = new Date(data.fecha_nacimiento);
                        edad = hoy.getFullYear() - nacimiento.getFullYear();
                        const mes = hoy.getMonth() - nacimiento.getMonth();
                        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                            edad--;
                        }
                    }

                    // Obtener cargo actual
                    const cargoActual = data.oficiales_cargos?.find(c => c.is_actual === 1)?.cargo.nombre_cargo || 'N/A';
                    console.log(data)
                    // Actualizar campos del modal
                    $('#documento_identidad_ficha').text(data.documento_identidad || 'N/A');
                    $('#nombre_completo_ficha').text(data.nombre_completo || 'N/A');
                    $('#fecha_nacimiento_ficha').text(data.fecha_nacimiento ? new Date(data.fecha_nacimiento).toLocaleDateString('es-ES') : 'N/A');
                    $('#edad_ficha').text(edad);
                    $('#tipo_sangre_ficha').text(data.tipo_sangre || 'N/A');
                    $('#estado_civil_ficha').text(data.estado_civil || 'N/A');
                    $('#direccion_ficha').text(data.direccion || 'N/A');
                    $('#centro_votacion_ficha').text(data.centro_votacion || 'N/A');
                    $('#telefono_ficha').text(data.telefono || 'N/A');
                    $('#correo_electronico_ficha').text(data.correo_electronico || 'N/A');
                    $('#numero_placa_ficha').text(data.numero_placa || 'N/A');
                    $('#fecha_ingreso_ficha').text(data.fecha_ingreso ? new Date(data.fecha_ingreso).toLocaleDateString('es-ES') : 'N/A');
                    $('#estatus_ficha').text(data.estatus || 'N/A');
                    $('#talla_camisa_ficha').text(data.talla_camisa || 'N/A');
                    $('#talla_pantalon_ficha').text(data.talla_pantalon || 'N/A');
                    $('#talla_zapatos_ficha').text(data.talla_zapatos || 'N/A');
                    $('#cargo_actual_ficha').text(cargoActual); 
                    $('#cargo_administrativo_actual_ficha').text((data.cargos_administrativo) ? data.cargos_administrativo.nombre_cargo : "S/A"); 
                    // Actualizar fotografía
                    const fotoOficial = $('#foto-oficial');
                    fotoOficial.attr('src', data.fotografia ? `storage/${data.fotografia}` : 'images/oficial-icon.png');

                    // Actualizar pie de página con fecha actual
                    $('.ficha-footer').text(`Generado el ${new Date().toLocaleDateString('es-ES')} | Sistema de Gestión Policial xAI`);

                    // Mostrar el modal (Bootstrap 5)
                    const modal = new bootstrap.Modal(document.getElementById('modal-ficha'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error al obtener los datos del oficial:', error);
                    alert('No se pudieron cargar los datos del oficial. Por favor, intenta de nuevo.');
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

        
        
    });
    
    function printFicha() {
        const fichaContent = document.querySelector('.ficha-container').innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = `<div class="ficha-container">${fichaContent}</div>`;
        window.print();
        document.body.innerHTML = originalContent;
    }

    function index() {
        fetch('api/officers')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let template = '';
                data.forEach(e => {
                    template += `
                    <tr>
                        <td class="text-center">${e.numero_placa ? e.numero_placa : 'S/NC'}</td>
                        <td class="text-center">${e.documento_identidad}</td>
                        <td class="text-center">${e.nombre_completo}</td>
                        <td class="text-center">${e.telefono ? e.telefono : 'S/T'}</td>
                        <td class="text-center">${e.fecha_ingreso ? e.fecha_ingreso.substr(0,4) + '-' + e.fecha_ingreso.substr(5,2) + '-' + e.fecha_ingreso.substr(8,2) : 'S/F'}</td>
                        <td class="text-center">${e.oficiales_cargos.find(c => c.is_actual === 1)?.cargo.nombre_cargo || 'N/A'}</td>
                        <td class="text-center">${(e.cargos_administrativo) ? e.cargos_administrativo.nombre_cargo : 'S/A'}</td>
                        <td class="text-center">${e.estatus.toUpperCase()}</td>
                        <td class="text-right actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v" data-toggle="tooltip" data-placement="top" title="Más acciones"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                    <button class="btn dropdown-item edit" data-id="${e.id}" data-toggle="tooltip" data-placement="top" title="Editar oficial"><i class="far fa-edit"></i> Editar</button>
                                    <button class="btn dropdown-item ficha" data-id="${e.id}" data-toggle="tooltip" data-placement="top" title="Ver oficial"><i class="fas fa-id-card-alt"></i> Ver oficial</button>
                                    <a class="btn dropdown-item" href="officers/radiogram/${e.id}" data-toggle="tooltip" data-placement="top" title="Radiograma"><i class="fas fa-street-view"></i> Radiograma</a>
                                    <a class="btn dropdown-item" href="officers/academy/${e.id}" data-toggle="tooltip" data-placement="top" title="Formación académica"><i class="fas fa-graduation-cap"></i> Formación académica</a>
                                    <a class="btn dropdown-item" href="officers/courses/${e.id}" data-toggle="tooltip" data-placement="top" title="Cursos y diplomados"><i class="fas fa-book-reader"></i> Cursos y diplomados</a>
                                    <a class="btn dropdown-item" href="officers/positions/${e.id}" data-toggle="tooltip" data-placement="top" title="Jerarquías obtenidas"><i class="fas fa-medal"></i> Jerarquías obtenidas</a>
                                    <a class="btn dropdown-item" href="officers/awards/${e.id}" data-toggle="tooltip" data-placement="top" title="Reconocimientos"><i class="fas fa-trophy"></i> Reconocimientos</a>
                                    <a class="btn dropdown-item" href="officers/familly/${e.id}" data-toggle="tooltip" data-placement="top" title="Hijos y familiares"><i class="fab fa-gratipay"></i> Hijos y familiares</a>
                                    <a class="btn dropdown-item" href="officers/health/${e.id}" data-toggle="tooltip" data-placement="top" title="Reposos médicos"><i class="fas fa-medkit"></i> Reposos médicos</a>
                                    <button class="btn dropdown-item files" data-id="${e.id}" data-toggle="tooltip" data-placement="top" title="Archivos del oficial"><i class="fas fa-file"></i> Archivos del oficial</button>
                                    <a class="btn dropdown-item" href="officers/vacations/${e.id}" data-toggle="tooltip" data-placement="top" title="Solicitud de vacaciones"><i class="fas fa-plane-departure"></i> Solicitud de vacaciones</a>
                                    <div class="dropdown-divider"></div>
                                    <button class="btn dropdown-item delete text-danger" data-id="${e.id}" data-toggle="tooltip" data-placement="top" title="Eliminar oficial"><i class="far fa-trash-alt"></i> Eliminar</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    `;
                });
                $('table').DataTable().destroy();
                $('tbody').html(template);
                $('table').DataTable(t);

                // Inicializar tooltips
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
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
</script>
@endsection