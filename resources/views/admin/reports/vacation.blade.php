@extends('layouts.report')

@section('content')
<div class="grid">
    <div><span class="label">SE HACE CONSTAR QUE LA CUIDADANO (A): </span> <span class="input-field">{{$oficial->oficiale->nombre_completo}}</span></div>
</div>
<div class="grid">
    <div><span class="label">CPET: </span> <span class="input-field"></span>{{$oficial->oficiale->numero_placa}}</div>
    <div><span class="label">PORTADOR DE LA CÉDULA DE IDENTIDAD N° V</span> <span class="input-field">{{$oficial->oficiale->documento_identidad}}</span></div>
</div>
<div class="grid">
    <div><span class="label">CON UBICACIÓN EN:</span> <span class="input-field">{{$oficial->oficiale->direccion}}</span></div>
</div>
<div class="grid">
    <div><span class="label">DESDE EL DÍA:</span> <span class="input-field">{{ \Carbon\Carbon::parse($oficial->fecha_emision)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</span></div>
    <div><span class="label">HASTA EL DÍA:</span> <span class="input-field">{{ \Carbon\Carbon::parse($oficial->fecha_reintegro)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</span></div>
</div>
<div class="grid">
    <div><span class="label">FECHA DE REINTEGRO:</span> <span class="input-field">{{ \Carbon\Carbon::parse($oficial->fecha_reintegro)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</span></div>
</div>
<div class="grid">
    <div class="grid-full"><span class="label">TIPO DE PERMISO: </span> <span class="input-field">{{$tipo}}</span></div>
</div>
<div class="grid">
    <div class="grid-full"><span class="label">PARA TRASLADARSE POR TODO EL TERRITORIO NACIONAL.</span></div>
</div>
@endsection