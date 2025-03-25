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
            <form id="form-add">
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
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="institucion">Institución</label>
                                <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese el nombre de la institución">
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-6 mb-3">
                                <label class="form-label" for="fecha_inicio">Fecha de inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <div class=" col-md-6 mb-3">
                                <label class="form-label" for="fecha_fin">Fecha de fin</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-12 mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
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
                formData.append('id_policia', '{{ $id }}');
            fetch('/cpet/public/api/officers/academy', {
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
            fetch('/cpet/public/api/officers/academy/'+id, {
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
            fetch('/cpet/public/api/officers/academy/'+id)
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
            fetch('/cpet/public/api/officers/academy/'+id, {
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
        });

        function index(){
            fetch('/cpet/public/api/officers/academy/index/{{ $id }}')
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
                        <div class="row border p-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 h4"><span class="font-weight-bold">${e.titulo}</span> - ${e.tipo_formacion} 
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
                                        <span class="text-muted">${e.institucion}</span>
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