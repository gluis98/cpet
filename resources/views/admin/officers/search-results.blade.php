@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Resultados de búsqueda</h2>
    <p class="text-muted">Consulta: <strong>{{ $q }}</strong> — {{ $resultados->count() }} coincidencia(s)</p>
    <hr>

    @if ($resultados->isEmpty())
        <div class="alert alert-warning">No se encontraron funcionarios.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Credencial</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultados as $r)
                        <tr>
                            <td>{{ $r->documento_identidad }}</td>
                            <td>{{ $r->nombre_completo }}</td>
                            <td>{{ $r->tipo_funcionario }}</td>
                            <td>{{ \App\Models\Oficiale::displayNumeroPlaca($r->numero_placa) }}</td>
                            <td>{{ $r->estatus }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('officers.ficha', $r->id) }}">Ver ficha</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
