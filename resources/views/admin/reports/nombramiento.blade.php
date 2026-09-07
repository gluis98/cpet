<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombramiento - {{ $funcionario->nombre_completo ?? 'Funcionario' }}</title>
    <style>
        @page {
            size: letter portrait;
            margin: 12mm 14mm;
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
            min-height: 279mm;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 8px 28px rgba(15, 39, 68, 0.12);
            padding: 10mm 12mm;
        }

        .frame {
            position: relative;
            border: 1.5px solid #111;
            min-height: calc(279mm - 20mm);
            padding: 8mm 10mm 10mm;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 320px;
            height: 320px;
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
            min-height: calc(279mm - 40mm);
        }

        .header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .header .logo {
            width: 70px;
            height: auto;
            flex-shrink: 0;
            object-fit: contain;
        }

        .membrete {
            flex: 1;
            margin: 0;
            text-align: center;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .meta {
            margin: 8px 0 18px;
            font-size: 13px;
            line-height: 1.55;
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
            font-size: 13.5px;
            line-height: 1.55;
            text-align: justify;
            margin: 0 0 14px;
        }

        .cuerpo .designacion {
            font-weight: 800;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .atentamente {
            margin: 18px 0 28px;
            font-size: 13.5px;
            font-weight: 700;
        }

        .firma {
            margin-top: auto;
            text-align: center;
            padding-top: 20px;
        }

        .firma .nombre {
            margin: 0;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.35;
        }

        .firma .cargo {
            margin: 4px 0 0;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .firma .decreto {
            margin: 8px auto 0;
            max-width: 420px;
            font-size: 9.5px;
            font-weight: 700;
            line-height: 1.35;
            text-transform: uppercase;
        }

        .iniciales {
            margin-top: 28px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .actions { display: none !important; }

            .sheet {
                box-shadow: none;
                width: auto;
                min-height: auto;
                padding: 0;
                margin: 0;
            }

            .frame {
                min-height: calc(100vh - 4mm);
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
