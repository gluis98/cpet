@extends('layouts.auth')

@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="row mb-3">
            
            <div class="col-md-12">
                <label for="email" class="font-weight-bold">{{ __('Correo electrónico') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            
            <div class="col-md-12">
                <label for="password" class="font-weight-bold">{{ __('Contraseña') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Recordarme') }}
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-0">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Iniciar sesión') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
                
@endsection
