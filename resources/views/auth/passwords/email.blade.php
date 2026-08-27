@extends('layouts.auth')

@section('title', 'Recuperar contraseña')

@section('content')
<div class="auth-panel">
    <div class="auth-brand">
        <div class="auth-brand__mark" aria-hidden="true">
            @if (file_exists(public_path('images/icon/logo.png')))
                <img src="{{ asset('images/icon/logo.png') }}" alt="">
            @else
                <span>CPET</span>
            @endif
        </div>
        <h2 class="auth-brand__name">CPET</h2>
        <p class="auth-brand__tag">Policía del Estado Trujillo</p>
    </div>

    <div class="auth-heading">
        <h1>Recuperar contraseña</h1>
        <p>Te enviaremos un enlace para restablecer el acceso.</p>
    </div>

    @if (session('status'))
        <div class="auth-alert auth-alert--info" role="status">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="auth-alert auth-alert--danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <div class="auth-field">
            <label for="email">Correo electrónico</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                required
                autocomplete="email"
                autofocus
            >
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-submit">Enviar enlace</button>
    </form>

    <p style="margin: 1.25rem 0 0; text-align: center;">
        <a class="auth-link" href="{{ route('login') }}">Volver al inicio de sesión</a>
    </p>
</div>
@endsection
