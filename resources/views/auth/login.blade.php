@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 shadow" style="border-radius: 10px;">
                <div class="card-header bg-primary text-white text-center py-4" style="background-color: #1E3A8A; border-radius: 10px 10px 0 0;">
                    <h4 class="mb-0 font-weight-bold">{{ __('Iniciar Sesión') }}</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-group mb-4">
                            <label for="email" class="font-weight-bold text-primary" style="color: #1E3A8A;">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   style="border-color: #60A5FA;">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-group mb-4">
                            <label for="password" class="font-weight-bold text-primary" style="color: #1E3A8A;">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   style="border-color: #60A5FA;">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}
                                       style="border-color: #1E3A8A;">
                                <label class="form-check-label text-primary" for="remember" style="color: #1E3A8A;">
                                    {{ __('Recordarme') }}
                                </label>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #60A5FA;">

                        <!-- Submit Button and Forgot Password Link -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block mb-3">
                                {{ __('Iniciar Sesión') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-primary" href="{{ route('password.request') }}" style="color: #1E3A8A;">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection