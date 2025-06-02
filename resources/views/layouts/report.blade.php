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
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        .grid-full {
            grid-column: 1 / -1;
        }
        .label {
            font-weight: bold;
        }
        .input-field {
            border-bottom: 1px solid #000;
            padding: 5px;
            width: 100%;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://via.placeholder.com/100" alt="Police Logo" class="logo">
            <h1>REPÚBLICA BOLIVARIANA DE VENEZUELA</h1>
            <h2>PODER PÚBLICO ESTADAL</h2>
            <h3>GOBIERNO BOLIVARIANO DEL ESTADO TRUJILLO</h3>
            <h4>CUERPO DE POLICÍA DEL ESTADO TRUJILLO</h4>
            <h4>DIRECCIÓN GENERAL DE POLICÍA</h4>
            <h4>OFICINA DE TALENTO HUMANO</h4>
            <div class="title">BOLETA DE VACACIONES</div>
        </div>
        <div class="content">
           @yield('content')
            <div class="footer">
                <p>CONFORME</p>
                <p>MAYOR (RA) ADAMES RANGEL YELFFRY JAVIER</p>
                <p>DIRECTOR GENERAL DEL CUERPO POLICÍA DEL ESTADO TRUJILLO</p>
                <p>SEGÚN DECRETO N° 3755 DE FECHA 11/08/2022 Y PUBLICADA EN GACETA OFICIAL DEL ESTADO TRUJILLO N° 3839 DE FECHA 11/08/2022</p>
            </div>
        </div>
    </div>
</body>
</html>