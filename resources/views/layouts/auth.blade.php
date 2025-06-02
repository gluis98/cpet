<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{ asset("images/icon/logo.png")}}" type="image/x-icon">
    
</head>
<body class="bg-primary bg-gradient">
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow my-5">
                            <div class="card-header text-center font-weight-bold">Autenticación</div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 border-right">
                                        @yield('content')
                                    </div>
                                    <div class="col-md-6 text-center justify-content-center align-self-center">
                                        <img src="{{asset('images/icon/logo.png')}}" alt="Logo" class="img-fluid" style="object-fit: contain">
                                        <h4>Cuerpo de Policias del Estado Trujillo</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
