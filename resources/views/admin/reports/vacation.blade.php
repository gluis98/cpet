<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Vacaciones</title>
    <style>
        @page {
            size: A4 portrait;
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
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 8px 28px rgba(15, 39, 68, 0.12);
            padding: 6mm 8mm;
            display: flex;
            flex-direction: column;
            gap: 4mm;
        }

        .boleta {
            flex: 1 1 50%;
            border: 1px solid #111;
            padding: 5mm 6mm 4mm;
            display: flex;
            flex-direction: column;
            min-height: 0;
            page-break-inside: avoid;
        }

        .boleta + .boleta {
            border-top: 1.5px dashed #94a3b8;
            margin-top: 1mm;
            padding-top: 5mm;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .header .logo {
            width: 58px;
            height: auto;
            flex-shrink: 0;
        }

        .membrete {
            flex: 1;
            margin: 0;
            font-size: 9.5px;
            font-weight: 700;
            line-height: 1.25;
            text-align: center;
            text-transform: uppercase;
        }

        .title {
            text-align: center;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.04em;
            margin: 6px 0 8px;
            text-transform: uppercase;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 4px 10px;
            margin-bottom: 5px;
        }

        .grid > div {
            flex: 1 1 100%;
            font-size: 11px;
            line-height: 1.35;
        }

        .grid.two > div {
            flex: 1 1 calc(50% - 6px);
            min-width: 140px;
        }

        .label {
            font-weight: 700;
            text-transform: uppercase;
        }

        .input-field {
            text-transform: uppercase;
            border-bottom: 1px solid #111;
            display: inline;
            padding: 0 2px 1px;
        }

        .footer {
            margin-top: auto;
            padding-top: 8px;
            font-size: 10.5px;
            font-weight: 700;
        }

        .footer .conforme {
            margin: 0 0 10px;
        }

        .footer .firma {
            text-align: center;
            margin: 0;
            line-height: 1.35;
            text-transform: uppercase;
        }

        .footer .cargo {
            font-size: 9.5px;
            font-weight: 700;
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
            }

            .boleta {
                border: 1px solid #111;
            }
        }
    </style>
</head>
<body>
@php
    $oficialNombre = $oficial->oficiale->nombre_completo ?? '—';
    $placa = $oficial->oficiale->numero_placa ?? '—';
    $cedula = $oficial->oficiale->documento_identidad ?? '—';
    $direccion = $oficial->oficiale->direccion ?? '—';
    $fmt = function ($d) {
        if (! $d) {
            return '—';
        }

        return \Carbon\Carbon::parse($d)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
    };
    $desde = $fmt($oficial->fecha_emision);
    $hasta = $fmt($oficial->fecha_hasta ?? $oficial->fecha_reintegro);
    $reintegro = $fmt($oficial->fecha_reintegro);
    $director = trim((string) ($entidad->director_general ?? '')) ?: '________________________';
@endphp

<div class="actions">
    <button type="button" onclick="window.print()">Imprimir boletas</button>
</div>

<div class="sheet">
    @for ($copia = 1; $copia <= 2; $copia++)
        <article class="boleta">
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

            <div class="title">{{ $title }}</div>

            <div class="grid">
                <div>
                    <span class="label">Se hace constar que el ciudadano (a):</span>
                    <span class="input-field">{{ $oficialNombre }}</span>
                </div>
            </div>
            <div class="grid two">
                <div>
                    <span class="label">CPET:</span>
                    <span class="input-field">{{ $placa }}</span>
                </div>
                <div>
                    <span class="label">Cédula de identidad N° V:</span>
                    <span class="input-field">{{ $cedula }}</span>
                </div>
            </div>
            <div class="grid">
                <div>
                    <span class="label">Con ubicación en:</span>
                    <span class="input-field">{{ $direccion }}</span>
                </div>
            </div>
            <div class="grid two">
                <div>
                    <span class="label">Desde el día:</span>
                    <span class="input-field">{{ $desde }}</span>
                </div>
                <div>
                    <span class="label">Hasta el día:</span>
                    <span class="input-field">{{ $hasta }}</span>
                </div>
            </div>
            <div class="grid">
                <div>
                    <span class="label">Fecha de reintegro:</span>
                    <span class="input-field">{{ $reintegro }}</span>
                </div>
            </div>
            <div class="grid">
                <div>
                    <span class="label">Tipo de permiso:</span>
                    <span class="input-field">{{ $tipo }}</span>
                </div>
            </div>
            <div class="grid">
                <div>
                    <span class="label">Para trasladarse por todo el territorio nacional.</span>
                </div>
            </div>

            <div class="footer">
                <p class="conforme">CONFORME:</p>
                <p class="firma">
                    {{ $director }}<br>
                    <span class="cargo">
                        DIRECTOR GENERAL DEL CUERPO POLICÍA DEL ESTADO TRUJILLO<br>
                        SEGÚN DECRETO N° 3755 DE FECHA 11/08/2022 Y PUBLICADA EN GACETA OFICIAL DEL ESTADO TRUJILLO N° 3839 DE FECHA 11/08/2022
                    </span>
                </p>
            </div>
        </article>
    @endfor
</div>
</body>
</html>
