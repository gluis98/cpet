@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('content')
<div class="auth-panel">
    @include('partials.auth-brand')

    <div class="auth-heading">
        <h1>Iniciar sesión</h1>
        <p>Accede al sistema de control de personal.</p>
    </div>

    @if ($errors->any())
        <div class="auth-alert auth-alert--danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
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
                placeholder="usuario@ejemplo.com"
            >
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password">Contraseña</label>
            <input
                id="password"
                type="password"
                name="password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            >
            @error('password')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-row">
            <label class="auth-check" for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                Recordarme
            </label>

            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <button type="submit" class="auth-submit">Entrar</button>
    </form>
</div>
@endsection
