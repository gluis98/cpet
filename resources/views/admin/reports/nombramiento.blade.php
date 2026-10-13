<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombramiento - {{ $funcionario->nombre_completo ?? 'Funcionario' }}</title>
    <style>
        @page {
            size: letter portrait;
            margin: 10mm 12mm;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 12px;
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            background: #e8eef5;
        }

        .actions {
            text-align: center;
            margin: 0 auto 12px;
        }

        .actions button {
            border: 0;
            background: #1a4574;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .sheet {
            width: 216mm;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 8px 28px rgba(15, 39, 68, 0.12);
            padding: 8mm 10mm;
        }

        .frame {
            position: relative;
            border: 1.5px solid #111;
            padding: 7mm 9mm 8mm;
            overflow: visible;
            display: flex;
            flex-direction: column;
            /* Área útil letter (~279mm) menos márgenes de pantalla */
            min-height: 250mm;
        }

        .watermark {
            position: absolute;
            top: 48%;
            left: 50%;
            width: 280px;
            height: 280px;
            transform: translate(-50%, -50%);
            opacity: 0.07;
            object-fit: contain;
            pointer-events: none;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .header .logo {
            width: 62px;
            height: auto;
            flex-shrink: 0;
            object-fit: contain;
        }

        .membrete {
            flex: 1;
            margin: 0;
            text-align: center;
            font-size: 10.5px;
            font-weight: 700;
            line-height: 1.28;
            text-transform: uppercase;
        }

        .meta {
            margin: 4px 0 12px;
            font-size: 12.5px;
            line-height: 1.5;
            flex-shrink: 0;
        }

        .meta .row {
            margin-bottom: 2px;
        }

        .meta .label {
            font-weight: 700;
            text-transform: uppercase;
        }

        .meta .asunto {
            font-weight: 800;
            text-decoration: underline;
        }

        .cuerpo {
            font-size: 12.5px;
            line-height: 1.5;
            text-align: justify;
            margin: 0 0 10px;
            flex-shrink: 0;
        }

        .cuerpo .designacion {
            font-weight: 800;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .atentamente {
            margin: 10px 0 16px;
            font-size: 12.5px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .firma {
            margin-top: auto;
            text-align: center;
            padding-top: 14px;
            flex-shrink: 0;
        }

        .firma .nombre {
            margin: 0;
            font-size: 12.5px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .firma .cargo {
            margin: 3px 0 0;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .firma .decreto {
            margin: 6px auto 0;
            max-width: 420px;
            font-size: 9px;
            font-weight: 700;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .iniciales {
            margin-top: 12px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.04em;
            flex-shrink: 0;
        }

        @media print {
            html, body {
                background: #fff;
                padding: 0;
                margin: 0;
                height: 100%;
            }

            .actions { display: none !important; }

            .sheet {
                box-shadow: none;
                width: 100%;
                height: 100%;
                min-height: 0;
                padding: 0;
                margin: 0;
            }

            .frame {
                width: 100%;
                height: 100%;
                min-height: 0;
                max-height: 100%;
                padding: 6mm 8mm 7mm;
                overflow: visible;
            }

            .content {
                height: 100%;
            }

            .firma {
                padding-top: 10px;
            }

            .iniciales {
                margin-top: 8px;
            }
        }
    </style>
</head>
<body>
<div class="actions">
    <button type="button" onclick="window.print()">Imprimir nombramiento</button>
</div>

<div class="sheet">
    <div class="frame">
        <img src="{{ asset('images/icon/logo.png') }}" alt="" class="watermark">

        <div class="content">
            <div class="header">
                <img src="{{ asset('images/icon/logo.png') }}" alt="Logo" class="logo">
                <p class="membrete">
                    REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                    PODER PÚBLICO ESTADAL<br>
                    GOBIERNO BOLIVARIANO DEL ESTADO TRUJILLO<br>
                    CUERPO DE POLICÍA DEL ESTADO TRUJILLO<br>
                    DIRECCIÓN GENERAL DE POLICÍA<br>
                    OFICINA DE TALENTO HUMANO
                </p>
                <img src="{{ asset('images/icon/gran-mision.png') }}" alt="Gran Misión" class="logo">
            </div>

            <div class="meta">
                <div class="row"><span class="label">N°</span> ________</div>
                <div class="row">
                    <span class="label">DEL CDNNO:</span>
                    {{ mb_strtoupper($director) }} DIRECTOR GENERAL DEL CUERPO DE POLICÍA DEL ESTADO TRUJILLO.
                </div>
                <div class="row">
                    <span class="label">AL CDNNO:</span>
                    {{ $destinatario }}
                    <span class="label">C. I. V:</span> {{ $cedula }}
                </div>
                <div class="row">
                    <span class="label">ASUNTO:</span>
                    <span class="asunto">NOMBRAMIENTO.</span>
                </div>
                <div class="row">
                    <span class="label">FECHA:</span>
                    {{ $fecha }}
                </div>
            </div>

            <p class="cuerpo">
                Tengo el agrado de dirigirme a usted, en la oportunidad de informarle que, a partir de la presente fecha,
                ha sido designado (a) como: <span class="designacion">{{ $designacion }}</span>.
                Igualmente lo invito junto a su excelente equipo de trabajo, a desempeñar sus funciones con lealtad y eficiencia,
                en pro de hacer de esta Institución Policial un modelo a seguir para el bienestar de la misma y de la colectividad;
                asumiendo sus actividades inherentes al cargo con responsabilidad, lealtad, profesión y sentido de pertenencia,
                garantes del Organismo que representa.
            </p>

            <p class="cuerpo">
                Comunicación que hago a usted, para su conocimiento y demás fines legales consiguientes.
            </p>

            <p class="atentamente">Atentamente,</p>

            <div class="firma">
                <p class="nombre">{{ mb_strtoupper($director) }}</p>
                <p class="cargo">DIRECTOR GENERAL DEL CUERPO DE POLICÍA DEL ESTADO TRUJILLO</p>
                <p class="decreto">
                    SEGÚN CONSTA EN DECRETO N° 3755 DE FECHA 11/08/2022 Y PUBLICADA EN GACETA OFICIAL
                    DEL ESTADO TRUJILLO N° 3839 DE FECHA 11/08/2022.
                </p>
            </div>

            @if ($iniciales !== '')
                <div class="iniciales">{{ $iniciales }}</div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
