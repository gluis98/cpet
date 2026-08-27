@extends('layouts.auth')

@section('title', 'Configuración inicial')

@section('content')
<div class="auth-panel">
    @include('partials.auth-brand')

    <div class="auth-heading">
        <h1>Configuración inicial</h1>
        <p>No hay usuarios en el sistema. Crea el primer administrador para comenzar.</p>
    </div>

    <div class="auth-alert auth-alert--info" role="status">
        Este paso solo aparece una vez. El usuario creado tendrá rol <strong>Administrador</strong>.
    </div>

    @if ($errors->any())
        <div class="auth-alert auth-alert--danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('setup.store') }}" novalidate>
        @csrf

        <div class="auth-field">
            <label for="name">Nombre completo</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                required
                autocomplete="name"
                autofocus
                placeholder="Nombre del administrador"
            >
            @error('name')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

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
                placeholder="admin@ejemplo.com"
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
                autocomplete="new-password"
                placeholder="Mínimo 8 caracteres"
            >
            @error('password')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Repite la contraseña"
            >
        </div>

        <button type="submit" class="auth-submit auth-submit--accent">Crear administrador</button>
    </form>
</div>
@endsection
