@extends('layouts.app')

@section('content')
<h2>{{$title}}</h2>
<hr>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Formulario</h2>
    <p class="text-muted">Los campos marcados con * son obligatorios.</p>
    <form id="policiaForm" class="shadow p-4 rounded bg-light">
        <div class="card">
            <div class="card-header">
                Datos personales
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Documento de identidad *</label>
                        <input type="text" class="form-control" id="documento_identidad" required placeholder="Ingrese número de cédula">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="nombre_completo" required placeholder="Ingrese el nombre completo">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fotografía *</label>
                        <input type="file" class="form-control" id="fotografia" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" required>
                    </div>
                    <div class="col-md-4">
                        
                    </div>
                </div>
            </div>
        </div>
       
        <div class="mb-3">
            <label class="form-label">Tipo de Sangre *</label>
            <input type="text" class="form-control" id="tipo_sangre" required placeholder="Ejemplo: O+">
        </div>
        <div class="mb-3">
            <label class="form-label">Talla de Ropa *</label>
            <input type="text" class="form-control" id="talla_ropa" required placeholder="Ejemplo: M, L, XL">
        </div>
        <div class="mb-3">
            
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Ingreso *</label>
            <input type="date" class="form-control" id="fecha_ingreso" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Puesto *</label>
            <input type="text" class="form-control" id="puesto" required placeholder="Ingrese el puesto">
        </div>
        <div class="mb-3">
            <label class="form-label">Estado Civil</label>
            <input type="text" class="form-control" id="estado_civil" placeholder="Ejemplo: Soltero, Casado">
        </div>
        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <textarea class="form-control" id="direccion" rows="2" placeholder="Ingrese la dirección"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono *</label>
            <input type="text" class="form-control" id="telefono" required placeholder="Ejemplo: +58 412 1234567">
        </div>
        <div class="mb-3">
            <label class="form-label">Correo Electrónico *</label>
            <input type="email" class="form-control" id="correo_electronico" required placeholder="Ingrese el correo electrónico">
        </div>
        <div class="mb-3">
            <label class="form-label">Documento de Identidad *</label>
            <input type="text" class="form-control" id="documento_identidad" required placeholder="Ingrese la cédula o pasaporte">
        </div>
        <div class="mb-3">
            <label class="form-label">Estatus *</label>
            <select class="form-control" id="estatus" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>
        <hr>
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary btn-lg" onclick="guardarPolicia()">
                <i class="fas fa-check-circle"></i>
                 Guardar
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    async function guardarPolicia() {
        const data = {
            nombre_completo: document.getElementById("nombre_completo").value,
            fecha_nacimiento: document.getElementById("fecha_nacimiento").value,
            tipo_sangre: document.getElementById("tipo_sangre").value,
            talla_ropa: document.getElementById("talla_ropa").value,
            puesto: document.getElementById("puesto").value
        };
        const response = await fetch("/api/policias", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });
        alert("Policía guardado exitosamente");
    }

    async function actualizarPolicia() {
        const id = prompt("Ingrese el ID del policía a actualizar:");
        const data = {
            nombre_completo: document.getElementById("nombre_completo").value,
            fecha_nacimiento: document.getElementById("fecha_nacimiento").value,
            tipo_sangre: document.getElementById("tipo_sangre").value,
            talla_ropa: document.getElementById("talla_ropa").value,
            puesto: document.getElementById("puesto").value
        };
        await fetch(`/api/policias/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });
        alert("Policía actualizado correctamente");
    }
</script>
@endsection