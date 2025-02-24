@extends('layouts.app')

@section('content')
<h2>{{$title}}</h2>
<hr>
<div class="container mt-5">
    <h2 class="mb-4">Formulario</h2>
    <form id="policiaForm">
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre_completo" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo de Sangre</label>
            <input type="text" class="form-control" id="tipo_sangre" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Talla de Ropa</label>
            <input type="text" class="form-control" id="talla_ropa" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Puesto</label>
            <input type="text" class="form-control" id="puesto" required>
        </div>
        <button type="button" class="btn btn-primary" onclick="guardarPolicia()">Guardar</button>
        <button type="button" class="btn btn-warning" onclick="actualizarPolicia()">Actualizar</button>
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