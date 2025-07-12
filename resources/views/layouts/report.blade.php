<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Vacaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px; 
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
            text-align: center;
        }

        .membrete {
            font-size: 12px;
            font-weight: bold;
        }
        /* Custom Grid System */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -10px;
            margin-right: -10px;
        }
        .col-1, .col-2, .col-3, .col-4, .col-5, .col-6,
        .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
            box-sizing: border-box;
            padding-left: 10px;
            padding-right: 10px;
        }
        .col-1 { width: 8.3333%; }
        .col-2 { width: 16.6667%; }
        .col-3 { width: 25%; }
        .col-4 { width: 33.3333%; }
        .col-5 { width: 41.6667%; }
        .col-6 { width: 50%; }
        .col-7 { width: 58.3333%; }
        .col-8 { width: 66.6667%; }
        .col-9 { width: 75%; }
        .col-10 { width: 83.3333%; }
        .col-11 { width: 91.6667%; }
        .col-12 { width: 100%; }
        .label {
            font-weight: bold;
        }
        .input-field {
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
            text-transform: uppercase;
            margin-bottom: 10px !important;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        @media print {
            body {
                padding: 0;
            }
            .container {
                border: none;
                padding: 10px;
            }
            .row {
                margin-left: 0;
                margin-right: 0;
            }
            .col-1, .col-2, .col-3, .col-4, .col-5, .col-6,
            .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
                padding-left: 5px;
                padding-right: 5px;
            }

            .jutify-content-center {
                justify-content: center !important;
            }
            .align-items-center {
                align-items: center !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header row jutify-content-center align-content-center">
            <div class="col-3">
                <img src="{{asset('images/icon/logo.png')}}" alt="Police Logo" class="logo">
            </div>
            <div class="col-6">
                <p class="membrete">REPÚBLICA BOLIVARIANA DE VENEZUELA <br>
                    PODER PÚBLICO ESTADAL <br>
                    GOBIERNO BOLIVARIANO DEL ESTADO TRUJILLO <br>
                    CUERPO DE POLICÍA DEL ESTADO TRUJILLO <br>
                    DIRECCIÓN GENERAL DE POLICÍA <br>
                    OFICINA DE TALENTO HUMANO</p>
            </div>
            <div class="col-3">
                <img src="{{asset('images/icon/gran-mision.png')}}" alt="Police Logo" class="logo">
            </div>
        </div>
        <div class="title">BOLETA DE VACACIONES</div>
        <div class="content">
            @yield('content')
            <div class="footer fw-bold">
                <p>CONFORME</p>
                <p class="text-center">{{$entidad->director_general}}</p>
                <p class="text-center">DIRECTOR GENERAL DEL CUERPO POLICÍA DEL ESTADO TRUJILLO</p>
                <p class="text-center">SEGÚN DECRETO N° 3755 DE FECHA 11/08/2022 Y PUBLICADA EN GACETA OFICIAL DEL ESTADO TRUJILLO N° 3839 DE FECHA 11/08/2022</p>
            </div>
            <p>{{ date('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>