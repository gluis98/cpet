@php
    $oficialId = (int) ($oficialId ?? ($oficial->id ?? 0));
    $tipoSlug = $tipoSlug ?? (array_search(($oficial->tipo_funcionario ?? 'Policial'), \App\Models\Oficiale::TIPOS_FUNCIONARIO, true) ?: 'policial');
    $showDelete = (bool) ($showDelete ?? false);
    $showFiles = (bool) ($showFiles ?? false);
    $btnClass = $btnClass ?? 'btn btn-dark btn-sm dropdown-toggle';
    $btnLabel = $btnLabel ?? 'Submódulos';
@endphp

@if ($oficialId > 0)
<div class="btn-group officers-submodulos-group">
    <button type="button" class="{{ $btnClass }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-th-list"></i> {{ $btnLabel }}
    </button>
    <div class="dropdown-menu dropdown-menu-right officers-submodulos-menu">
        <a class="dropdown-item" href="{{ url('/officers/tipo/'.$tipoSlug.'/'.$oficialId.'/edit') }}"><i class="far fa-edit"></i> Editar</a>
        <a class="dropdown-item" href="{{ url('/officers/ficha/'.$oficialId) }}"><i class="fas fa-id-card-alt"></i> Ver ficha</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('/officers/radiogram/'.$oficialId) }}"><i class="fas fa-street-view"></i> Radiograma</a>
        <a class="dropdown-item" href="{{ url('/officers/nombramientos/'.$oficialId) }}"><i class="fas fa-user-tie"></i> Nombramientos</a>
        <a class="dropdown-item" href="{{ url('/officers/academy/'.$oficialId) }}"><i class="fas fa-graduation-cap"></i> Formación académica</a>
        <a class="dropdown-item" href="{{ url('/officers/courses/'.$oficialId) }}"><i class="fas fa-book-reader"></i> Cursos y diplomados</a>
        <a class="dropdown-item" href="{{ url('/officers/positions/'.$oficialId) }}"><i class="fas fa-medal"></i> Jerarquías obtenidas</a>
        <a class="dropdown-item" href="{{ url('/officers/awards/'.$oficialId) }}"><i class="fas fa-trophy"></i> Reconocimientos</a>
        <a class="dropdown-item" href="{{ url('/officers/familly/'.$oficialId) }}"><i class="fab fa-gratipay"></i> Hijos y familiares</a>
        <a class="dropdown-item" href="{{ url('/officers/health/'.$oficialId) }}"><i class="fas fa-medkit"></i> Reposos médicos</a>
        <a class="dropdown-item" href="{{ url('/officers/icap/'.$oficialId) }}"><i class="fas fa-balance-scale"></i> ICAP</a>
        <a class="dropdown-item" href="{{ url('/officers/urra/'.$oficialId) }}"><i class="fas fa-shield-alt"></i> URRA</a>
        <a class="dropdown-item" href="{{ url('/officers/vacations/'.$oficialId) }}"><i class="fas fa-plane-departure"></i> Vacaciones</a>
        @if ($showFiles)
            <button class="dropdown-item files" data-id="{{ $oficialId }}" type="button"><i class="fas fa-file"></i> Archivos del oficial</button>
        @endif
        @if ($showDelete)
            <div class="dropdown-divider"></div>
            <button class="dropdown-item delete text-danger" data-id="{{ $oficialId }}" type="button"><i class="far fa-trash-alt"></i> Eliminar</button>
        @endif
    </div>
</div>
@endif
