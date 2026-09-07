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
            margin: 0 auto 16px;
            background: #fff;
            box-shadow: 0 8px 28px rgba(15, 39, 68, 0.12);
            padding: 6mm 8mm;
            display: flex;
            flex-direction: column;
            gap: 4mm;
        }

        .sheet-planilla {
            gap: 3mm;
        }

        .boleta,
        .planilla {
            flex: 1 1 50%;
            border: 1px solid #111;
            padding: 4mm 5mm 3mm;
            display: flex;
            flex-direction: column;
            min-height: 0;
            page-break-inside: avoid;
        }

        .boleta + .boleta,
        .planilla + .planilla {
            border-top: 1.5px dashed #94a3b8;
            margin-top: 1mm;
            padding-top: 4mm;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .header .logo {
            width: 52px;
            height: auto;
            flex-shrink: 0;
        }

        .membrete {
            flex: 1;
            margin: 0;
            font-size: 9px;
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

        /* ---- Planilla periodos (hoja 2) ---- */
        .planilla .fecha {
            text-align: right;
            font-size: 11px;
            margin: 2px 0 6px;
            font-weight: 600;
        }

        .planilla .destinatario {
            font-size: 11px;
            line-height: 1.35;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 0 8px;
        }

        .planilla .cuerpo {
            font-size: 11px;
            line-height: 1.4;
            text-align: justify;
            margin: 0 0 8px;
        }

        .planilla .cuerpo .fecha-ingreso {
            font-weight: 700;
            text-decoration: underline;
        }

        .vac-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 8px;
            table-layout: fixed;
        }

        .vac-table th,
        .vac-table td {
            border: 1px solid #111;
            vertical-align: top;
            padding: 4px 6px;
            font-size: 11px;
        }

        .vac-table th {
            text-align: center;
            font-weight: 700;
            background: #f3f4f6;
        }

        .vac-table td {
            min-height: 48px;
            height: 52px;
            line-height: 1.35;
        }

        .planilla .cierre {
            font-size: 11px;
            margin: 0 0 10px;
            line-height: 1.4;
        }

        .planilla .firma-oficial {
            text-align: center;
            margin-top: auto;
            padding-top: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.35;
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
                page-break-after: always;
            }

            .sheet:last-child {
                page-break-after: auto;
            }

            .boleta,
            .planilla {
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
    $rrhh = trim((string) ($entidad->rrhh ?? '')) ?: '________________________';
    $aniosDisfrutados = $aniosDisfrutados ?? [];
    $aniosNoDisfrutados = $aniosNoDisfrutados ?? [];
    $fechaIngresoFmt = $fechaIngresoFmt ?? '—';
    $fechaPlanilla = $fechaPlanilla ?? now()->format('d/m/Y');
    $rangoFirma = $rangoFirma ?? $oficialNombre;
    $textoAnios = function (array $anios) {
        return $anios === [] ? '' : implode(', ', $anios);
    };
@endphp

<div class="actions">
    <button type="button" onclick="window.print()">Imprimir boletas</button>
</div>

{{-- Hoja 1: dos boletas de vacaciones --}}
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

{{-- Hoja 2: planilla periodos disfrutados / no disfrutados (2 copias) --}}
<div class="sheet sheet-planilla">
    @for ($copia = 1; $copia <= 2; $copia++)
        <article class="planilla">
            <div class="header">
                <img src="{{ asset('images/icon/logo.png') }}" alt="Logo" class="logo">
                <p class="membrete">
                    REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                    GOBIERNO BOLIVARIANO DEL ESTADO TRUJILLO<br>
                    CUERPO DE POLICÍA DEL ESTADO TRUJILLO<br>
                    DIRECCIÓN GENERAL DEL CUERPO DE POLICÍA DEL ESTADO TRUJILLO
                </p>
                <img src="{{ asset('images/icon/gran-mision.png') }}" alt="Gran Misión" class="logo">
            </div>

            <p class="fecha">Trujillo, {{ $fechaPlanilla }}</p>

            <p class="destinatario">
                CIUDADANO(A):<br>
                {{ $rrhh }}<br>
                DIRECTOR DE TALENTO HUMANO<br>
                SU DESPACHO. -
            </p>

            <p class="cuerpo">
                Reciba un cordial saludo por medio de la presente me dirijo a usted en la oportunidad
                de informarle que en fecha; <span class="fecha-ingreso">{{ $fechaIngresoFmt }}</span>
                ingrese a la institución en la cual doy fe de los periodos vacaciones disfrutados y no disfrutados.
            </p>

            <table class="vac-table">
                <thead>
                    <tr>
                        <th>Vacaciones no Disfrutadas</th>
                        <th>Vacaciones Disfrutadas.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $textoAnios($aniosNoDisfrutados) }}</td>
                        <td>{{ $textoAnios($aniosDisfrutados) }}</td>
                    </tr>
                </tbody>
            </table>

            <p class="cierre">
                Sin más a que hacer referencia me despido de usted;<br>
                Atentamente;
            </p>

            <p class="firma-oficial">
                {{ $rangoFirma }}<br>
                C.I.: {{ $cedula }}
            </p>
        </article>
    @endfor
</div>
</body>
</html>
