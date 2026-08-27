@php
    $logoPng = public_path('images/icon/logo.png');
    $logoSvg = public_path('images/icon/logo.svg');
@endphp
<div class="auth-brand">
    <div class="auth-brand__mark" aria-hidden="true">
        @if (file_exists($logoPng))
            <img src="{{ asset('images/icon/logo.png') }}" alt="CPET">
        @elseif (file_exists($logoSvg))
            <img src="{{ asset('images/icon/logo.svg') }}" alt="CPET">
        @else
            <span>CPET</span>
        @endif
    </div>
    <h2 class="auth-brand__name">CPET</h2>
    <p class="auth-brand__tag">Policía del Estado Trujillo</p>
</div>
