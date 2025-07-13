@extends('layouts.report')

@section('content')
<div class="grid text-right">
    <div><span class="label">Trujillo, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</span></div>
</div>
<div class="grid">
    <div><span class="label">RGDMA. Nro. C-G-P: </span> <span class="input-field">{{$oficial->id}}</span></div>
</div>
<div class="grid">
    <div><span class="label">Ciudadano(a)</div>
    <div><span class="label">{{ ($oficial->oficiale->oficiales_cargos->where('is_actual', 1)->first() != null) ? $oficial->oficiale->oficiales_cargos->where('is_actual', 1)->first()->cargo->nombre_cargo : "Sin Cargo" }}</span></div>
    <div style="display: flex; justify-content: space-between"><span class="label">{{$oficial->oficiale->nombre_completo}}</span> <span class="label">C.I.N: {{ number_format($oficial->oficiale->documento_identidad, 0, '', '.') }}</span></div>
</div>
<div class="grid">
    <div><span class="label">Presente:</span></div>
</div>
<div class="grid">
    <div><span class="input-field">PARA SU CONOCIMIENTO Y DEMÁS FINES DE ESTRICTO CUMPLIMIENTO, A PARTIR DE LA PRESENTE FECHA, PRESTARÁ SU SERVICIO EN El/LA {{$oficial->estacione->estacion}}, {{$oficial->descripcion}}, IGUALMENTE HAGO DE SU CONOCIMIENTO QUE DEBERÁ PRESENTARSE EN SU UNIDAD DE DESTINO.</span></div>
</div>
@endsection