<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Policía Estado Trujillo') }} - @yield('title', 'Autenticación')</title>

    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #E0F2FE; /* Light blue background */
            font-family: 'Arial', sans-serif;
            color: #1E3A8A; /* Dark blue text */
        }
        .navbar {
            background: linear-gradient(45deg, #1E3A8A, #60A5FA); /* Dark to light blue gradient */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .nav-link {
            color: #FFFFFF !important;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #F3F4F6 !important; /* Light gray hover */
        }
        .footer {
            background: #1E3A8A; /* Dark blue footer */
            color: #FFFFFF;
            padding: 1rem 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .main-content {
            min-height: calc(100vh - 56px - 60px); /* Adjust for navbar and footer */
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .btn-primary {
            background-color: #1E3A8A;
            border-color: #1E3A8A;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #152e6f;
            border-color: #152e6f;
        }
        .form-control:focus {
            border-color: #60A5FA;
            box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25);
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset("images/icon/logo.png") }}" alt="" width="50" height="50">
                Policía Estado Trujillo
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} Policía Estado Trujillo. Todos los derechos reservados. Desarrollado por: <a href="#" class="btn text-white font-weight-bold">Adsys Sistemas</a></p>
        </div>
    </footer>

    <!-- Bootstrap 4 JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @yield('scripts')
</body>
</html>