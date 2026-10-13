<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radiograma - {{ $funcionario->nombre_completo ?? 'Funcionario' }}</title>
    <style>
        @page {
            size: letter portrait;
            margin: 8mm 10mm;
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
            padding: 6mm 8mm;
            display: flex;
            flex-direction: column;
            gap: 4mm;
        }

        .radiograma {
            position: relative;
            flex: 1 1 50%;
            border: 1.5px solid #111;
            padding: 5mm 6mm 4mm;
            display: flex;
            flex-direction: column;
            min-height: 0;
            page-break-inside: avoid;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            top: 52%;
            left: 50%;
            width: 210px;
            height: 210px;
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
            flex: 1;
            min-height: 0;
        }

        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 4px;
        }

        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
            width: 88px;
        }

        .header-right {
            justify-content: flex-end;
        }

        .header .logo-sm {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .header .logo-md {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .header .logo-lg {
            width: 56px;
            height: 56px;
            object-fit: contain;
        }

        .membrete {
            flex: 1;
            margin: 0;
            padding: 0 2px;
            font-size: 9px;
            font-weight: 700;
            line-height: 1.28;
            text-align: center;
            text-transform: uppercase;
        }

        .fecha {
            text-align: right;
            font-size: 11px;
            font-weight: 600;
            margin: 2px 0 8px;
            text-transform: uppercase;
        }

        .nro {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 0 8px;
        }

        .destinatario {
            font-size: 11.5px;
            line-height: 1.4;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 0 8px;
        }

        .destinatario .presente {
            margin-top: 4px;
        }

        .cuerpo {
            font-size: 11.5px;
            line-height: 1.45;
            text-align: justify;
            text-transform: uppercase;
            margin: 0 0 10px;
        }

        .cuerpo .destacado {
            font-weight: 800;
            text-decoration: underline;
        }

        .cumplase {
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 4px 0 14px;
        }

        .firma {
            text-align: center;
            margin-top: auto;
            padding-top: 18px;
            text-transform: uppercase;
        }

        .firma .nombre {
            margin: 0 0 3px;
            font-size: 11.5px;
            font-weight: 800;
            line-height: 1.3;
        }

        .firma .cargo {
            margin: 0;
            font-size: 9.5px;
            font-weight: 700;
            line-height: 1.3;
        }

        .iniciales {
            margin-top: 10px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
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
                height: auto;
                padding: 0;
                gap: 3mm;
                margin: 0;
            }

            .radiograma {
                border: 1.5px solid #111;
            }
        }
    </style>
</head>
<body>
@php
    $rrhhNombre = trim((string) ($rrhh ?? '')) ?: '________________________';
    $dest = $destinatario ?? '________________________';
    $ci = $cedula ?? '—';
    $fechaTxt = $fecha ?? now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
    $nroTxt = $nro ?? 'C-G-P ___';
    $estacionTxt = $estacion ?? '________________';
    $especificoTxt = $especifico ?? null;
    $inicialesTxt = $iniciales ?? '';
@endphp

<div class="actions">
    <button type="button" onclick="window.print()">Imprimir radiograma</button>
</div>

<div class="sheet">
    @for ($copia = 1; $copia <= 2; $copia++)
        <article class="radiograma">
            <img src="{{ asset('images/icon/logo.png') }}" alt="" class="watermark">

            <div class="content">
                <div class="header">
                    <div class="header-left">
                        <img src="{{ asset('img/justicia.jpeg') }}" alt="Justicia y Paz" class="logo-md">
                        <img src="{{ asset('images/icon/logo.png') }}" alt="CPET" class="logo-sm">
                    </div>
                    <p class="membrete">
                        REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                        PODER PÚBLICO ESTADAL<br>
                        GOBIERNO BOLIVARIANO DEL ESTADO TRUJILLO<br>
                        CUERPO DE POLICÍA DEL ESTADO TRUJILLO<br>
                        DIRECCIÓN GENERAL DE POLICÍA<br>
                        OFICINA DE TALENTO HUMANO
                    </p>
                    <div class="header-right">
                        <img src="{{ asset('img/juntos.jpeg') }}" alt="Juntos por la Vida y la Paz" class="logo-lg">
                    </div>
                </div>

                <p class="fecha">TRUJILLO, {{ $fechaTxt }}</p>

                <p class="nro">RDGMA NRO. {{ $nroTxt }}</p>

                <div class="destinatario">
                    CIUDADANO (A):<br>
                    {{ $dest }}<br>
                    C.I. N {{ $ci }}<br>
                    <div class="presente">PRESENTE;</div>
                </div>

                <p class="cuerpo">
                    PARA SU CONOCIMIENTO Y DEMÁS FINES DE ESTRICTO CUMPLIMIENTO, A PARTIR DE LA PRESENTE FECHA,
                    PRESTARÁ SU SERVICIO EN:
                    <span class="destacado">{{ $estacionTxt }}</span>@if($especificoTxt),
                    ESPECÍFICAMENTE EN <span class="destacado">{{ $especificoTxt }}</span>@endif.
                    IGUALMENTE HAGO DE SU CONOCIMIENTO QUE DEBERÁ PRESENTARSE EN SU UNIDAD DE DESTINO.
                </p>

                <p class="cumplase">CÚMPLASE:</p>

                <div class="firma">
                    <p class="nombre">{{ mb_strtoupper($rrhhNombre) }}</p>
                    <p class="cargo">
                        DIRECTOR DE LA OFICINA DE TALENTO HUMANO DE LA DIRECCIÓN GENERAL<br>
                        DEL CUERPO DE POLICÍA DEL ESTADO TRUJILLO
                    </p>
                </div>

                @if ($inicialesTxt !== '')
                    <div class="iniciales">{{ $inicialesTxt }}</div>
                @endif
            </div>
        </article>
    @endfor
</div>
</body>
</html>
