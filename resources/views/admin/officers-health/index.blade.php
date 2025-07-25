@extends('layouts.app')

@section('content')
{{-- INICIO MODALES --}}
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Registrar salud</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="form-add">
                @csrf
                <div class="aler alert-info p-2 border mb-3">
                    <p class="text-muted">Los campos marcados con (*) son obligatorios.</p>
                </div>
                <div class="card">
                    <div class="card-header">
                        Datos de la solicitud
                    </div>
                    <div class="card-body">
                        <div class="row  mb-3">
                            <div class="col-md-12">
                                <label class="form-label" for="fecha_revision">Fecha Revisión *</label>
                                <input type="date" class="form-control" id="fecha_revision" name="fecha_revision" required>
                            </div>                            
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="diagnostico">Diagnóstico *</label>
                                <textarea class="form-control" id="diagnostico" name="diagnostico" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="fecha_reposo_inicio">Fecha Reposo Inicio *</label>
                                <input type="date" class="form-control" id="fecha_reposo_inicio" name="fecha_reposo_inicio" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="fecha_reposo_fin">Fecha Reposo Fin *</label>
                                <input type="date" class="form-control" id="fecha_reposo_fin" name="fecha_reposo_fin" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="dias_reposo">Días Reposo *</label>
                                <input type="number" class="form-control" id="dias_reposo" name="dias_reposo" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="is_vigente">¿Vigente? *</label>
                                <select class="form-control" id="is_vigente" name="is_vigente" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
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

<!-- Modal for File Upload -->
<div class="modal fade" id="uploadFiles" tabindex="-1" role="dialog" aria-labelledby="uploadFilesLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="uploadFilesLabel">Subir Archivos de Reposo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="myDropzone" class="dropzone" action="/cpet/public/api/officers/health/files/add-files/{{ $id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </form>
                <hr>
                <h5>Previsualización de Reposos</h5>
                <div id="filePreview" class="list-group"></div>
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
                <i class="zmdi zmdi-plus"></i>Agregar solicitud de salud
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
                    <th class="text-center" scope="col">Fecha Revisión</th>
                    <th class="text-center" scope="col">Diagnóstico</th>
                    <th class="text-center" scope="col">Fecha Reposo Inicio</th>
                    <th class="text-center" scope="col">Fecha Reposo Fin</th>
                    <th class="text-center" scope="col">Días Reposo</th>
                    <th class="text-center" scope="col">¿Vigente?</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script>
    // Initialize Dropzone
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        var id = "";
        index(); 

        $('#btn-add').click(function(e){
            e.preventDefault();
            $('#form-edit').attr('id', 'form-add');
            $('#form-add').trigger('reset');
            $('#btn-submit').text('Guardar');
            $('#btn-submit').attr('class', 'btn btn-primary btn-lg');
            $('#add').modal('show'); 
        });

        $(document).on('submit','#form-add', function(e){
            e.preventDefault();
            let formData = new FormData(this);
                formData.append('id_policia', "{{ $id }}");
            fetch('/cpet/public/api/officers/health', {
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
            fetch('/cpet/public/api/officers/health/' + id, {
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
            fetch('/cpet/public/api/officers/health/' + id)
            .then(response => response.json())
            .then(data => {
                $('#id_policia').val(data.id_policia);
                $('#fecha_revision').val(data.fecha_revision.substr(0,4) + '-' + data.fecha_revision.substr(5,2) + '-' + data.fecha_revision.substr(8,2));
                $('#fecha_reposo_inicio').val(data.fecha_reposo_inicio ? data.fecha_reposo_inicio.substr(0,4) + '-' + data.fecha_reposo_inicio.substr(5,2) + '-' + data.fecha_reposo_inicio.substr(8,2) : '');
                $('#fecha_reposo_fin').val(data.fecha_reposo_fin ? data.fecha_reposo_fin.substr(0,4) + '-' + data.fecha_reposo_fin.substr(5,2) + '-' + data.fecha_reposo_fin.substr(8,2) : '');
                $('#dias_reposo').val(data.dias_reposo);
                $('#diagnostico').val(data.diagnostico);
                $('#is_vigente').val(data.is_vigente);

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
                    fetch('/cpet/public/api/officers/health/' + id, {
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
        });

        function index(){
            fetch('/cpet/public/api/officers/health/index/' + '{{ $id }}')
            .then(response => response.json())
            .then(data => {
                let template = '';
                data.forEach(e => {
                    template += `
                    <tr>
                        <td class="text-center">${new Date(e.fecha_revision).toLocaleDateString('es-ES', {year: 'numeric', month: '2-digit', day: '2-digit'})}</td>
                        <td class="text-center">${e.diagnostico}</td>
                        <td class="text-center">${e.fecha_reposo_inicio ? new Date(e.fecha_reposo_inicio).toLocaleDateString('es-ES', {year: 'numeric', month: '2-digit', day: '2-digit'}) : ''}</td>
                        <td class="text-center">${e.fecha_reposo_fin ? new Date(e.fecha_reposo_fin).toLocaleDateString('es-ES', {year: 'numeric', month: '2-digit', day: '2-digit'}) : ''}</td>
                        <td class="text-center">${e.dias_reposo}</td>
                        <td class="text-center">${e.is_vigente ? 'Sí' : 'No'}</td>
                        <td class="text-right">
                            <button class="btn btn-dark edit" data-id="${e.id}"><i class="far fa-edit"></i></button>
                            <button class="btn btn-danger delete" data-id="${e.id}"><i class="far fa-trash-alt"></i></button>
                            <button class="btn btn-info files" data-id="${e.id}" data-toggle="modal" data-target="#uploadFiles"><i class="fas fa-upload"></i></button>
                        </td>
                    </tr>
                    `;
                });
                $('table').DataTable().destroy();
                $('tbody').html(template);
                $('table').DataTable(t);
            });
        }

        
        $(document).on('click', '.files', function() {
            id = $(this).attr('data-id');
            // Note that the name "myDropzone" is the camelized
            loadFilePreview(id)
            if (!Dropzone.instances.length) { 
                const dropzone =  new Dropzone('#myDropzone', {
                    url: '/cpet/public/api/officers/files/reposos/'+id,  // URL donde se enviarán los archivos
                    method: 'POST', //Método por el cual se enviarán los archivos
                    paramName: 'archivos',          // El nombre del campo de archivo en el backend
                    maxFilesize: 2,             // Tamaño máximo en MB
                    acceptedFiles: '.jpg,.jpeg,.png',  // Tipos de archivo aceptados
                    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos',
                    success: function(file, response) {
                        loadFilePreview(id);
                    },
                    error: function(file, response) {
                        console.error("Error al subir archivo:", response);
                    }
                });
            }
            $('#uploadFiles').modal('show');
        })

        function loadFilePreview(id) {
            fetch('/cpet/public/api/officers/files/reposos/' + id)
            .then(response => response.json())
            .then(data => {
                let preview = '';
                data.forEach(file => {
                    preview += `
                    <div class="list-group-item">
                        <a href="/cpet/public/storage/${file.archivo}" target="_blank" class="btn btn-success btn-sm">Descargar</a>
                        <button class="btn btn-danger btn-sm delete-file" data-id="${file.id}">Eliminar</button>
                        <span>${file.archivo}</span>
                    </div>
                    `;
                });
                $('#filePreview').html(preview);

                $('.delete-file').on('click', function(e) {
                    e.preventDefault();
                    let fileId = $(this).data('id');
                    let formData = new FormData();
                    formData.append('_method', 'DELETE');
                    fetch(`/cpet/public/api/officers/health/files/add-files/${fileId}`, {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: data.msj,
                            icon: "success",
                            draggable: true
                        });
                        loadFilePreview(fileId);
                    });
                });
            });
        }

        // Update dias_reposo when dates change
        $('#fecha_reposo_fin').on('change', function() {
            console.log("pña")
            let startDate = $('#fecha_reposo_inicio').val();
            let endDate = $('#fecha_reposo_fin').val();
            if (startDate && endDate) {
                let days = calculateBusinessDays(startDate, endDate);
                $('#dias_reposo').val(days);
            }
        });

        function calculateBusinessDays(startDate, endDate) {
            let start = new Date(startDate);
            let end = new Date(endDate);
            let businessDays = 0;

            // Ensure start date is not after end date
            if (start > end) return 0;

            while (start <= end) {
                let dayOfWeek = start.getDay();
                // Check if the day is a weekday (Monday = 1, Friday = 5)
                if (dayOfWeek >= 1 && dayOfWeek <= 5) {
                    businessDays++;
                }
                start.setDate(start.getDate() + 1);
            }

            return businessDays;
        }
    });
</script>
@endsection