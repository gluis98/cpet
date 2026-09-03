<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha URRA — {{ $officer->nombre_completo ?? 'Funcionario' }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 12px;
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            background: #dbe3ee;
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
            width: 297mm;
            height: 210mm;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 10px 36px rgba(15, 39, 68, 0.18);
            display: flex;
            flex-direction: row;
            overflow: hidden;
            position: relative;
        }

        .sheet::before {
            content: '';
            position: absolute;
            inset: 14mm 18mm 14mm 72mm;
            background: url('{{ asset('images/icon/logo.png') }}') center / contain no-repeat;
            opacity: 0.07;
            pointer-events: none;
            z-index: 0;
        }

        /* Cintillo vertical izquierdo (banner rotado, grande) */
        .cintillo {
            position: relative;
            z-index: 2;
            flex: 0 0 68mm;
            width: 68mm;
            height: 210mm;
            background: #000;
            overflow: hidden;
            border-right: 4px solid #c4122f;
        }

        .cintillo-inner {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 210mm;
            height: 68mm;
            transform: translate(-50%, -50%) rotate(-90deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cintillo-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .cintillo-empty {
            color: #fff;
            font-size: 11px;
            text-align: center;
            padding: 12px;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
        }

        .main {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            min-width: 0;
            height: 100%;
        }

        .col-datos {
            flex: 1 1 54%;
            padding: 10mm 8mm 10mm 7mm;
            display: flex;
            align-items: stretch;
            min-width: 0;
        }

        .datos-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            background: rgba(255, 255, 255, 0.88);
        }

        .datos-table th,
        .datos-table td {
            border: 1.6px solid #111;
            padding: 5.5mm 3.5mm;
            text-align: center;
            vertical-align: middle;
            font-weight: 700;
            font-size: 13px;
            line-height: 1.25;
        }

        .datos-table th {
            width: 42%;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            background: #fff;
            color: #111;
        }

        .datos-table td {
            width: 58%;
            word-break: break-word;
        }

        .datos-table tr:nth-child(1) td {
            background: #cfe8ff;
        }

        .datos-table tr:nth-child(3) td {
            background: #fff3b0;
        }

        .cargo-urra {
            color: #c4122f !important;
            font-weight: 800;
            text-transform: uppercase;
        }

        .col-foto {
            flex: 1 1 46%;
            border-left: 2px solid #111;
            background: #0b1d33;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
            min-width: 0;
            padding: 0;
        }

        .col-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .actions { display: none !important; }

            .sheet {
                box-shadow: none;
                width: 297mm;
                height: 210mm;
                margin: 0;
            }
        }
    </style>
</head>
<body>
@php
    $foto = ($officer && $officer->fotografia)
        ? asset('storage/'.$officer->fotografia)
        : asset('images/oficial-icon.png');

    $jerarquia = optional(
        optional($officer->oficiales_cargos)->firstWhere('is_actual', 1)
    )->cargo->nombre_cargo
        ?? optional($officer->cargos_administrativo)->nombre_cargo
        ?? '—';

    $armamento = trim((string) ($urra->armamento_serial ?? ''));
    if ($armamento === '' && $officer && $officer->armamentos && $officer->armamentos->count()) {
        $armamento = $officer->armamentos->map(function ($arma) {
            $nombre = trim((string) ($arma->nombre ?? ''));
            $serial = trim((string) ($arma->serial ?? ''));
            if ($nombre !== '' && $serial !== '') {
                return $nombre.' / '.$serial;
            }

            return $serial !== '' ? $serial : $nombre;
        })->filter()->implode(' · ');
    }
    if ($armamento === '') {
        $armamento = '0';
    }

    $unidadOrigen = trim((string) ($urra->unidad_origen ?? '')) ?: 'CPET';
    $cuenta = trim((string) ($urra->cuenta_bancaria ?? '')) ?: '—';
    $cargoUrra = trim((string) ($urra->cargo_urra ?? '')) ?: '—';
    $poligono = trim((string) ($urra->ultimo_poligono ?? '')) ?: '0';
    $telefono = trim((string) ($officer->telefono ?? '')) ?: '—';
    $direccion = trim((string) ($officer->direccion ?? '')) ?: '—';
    $sangre = trim((string) ($officer->tipo_sangre ?? '')) ?: '—';
@endphp

<div class="actions">
    <button type="button" onclick="window.print()">Imprimir ficha</button>
</div>

<div class="sheet">
    <aside class="cintillo" aria-label="Cintillo institucional">
        @if (! empty($logos))
            <div class="cintillo-inner">
                <img src="{{ $logos[0] }}" alt="Cintillo URRA">
            </div>
        @else
            <div class="cintillo-empty">Coloque el cintillo en public/img/urra/1.png</div>
        @endif
    </aside>

    <div class="main">
        <section class="col-datos">
            <table class="datos-table">
                <tr>
                    <th>C.I.V</th>
                    <td>{{ $officer->documento_identidad ?? '—' }}</td>
                </tr>
                <tr>
                    <th>NOMBRES Y APELLIDOS</th>
                    <td>{{ $officer->nombre_completo ?? '—' }}</td>
                </tr>
                <tr>
                    <th>RANGO / JERARQUÍA</th>
                    <td>{{ $jerarquia }}</td>
                </tr>
                <tr>
                    <th>TIPO DE SANGRE</th>
                    <td>{{ $sangre }}</td>
                </tr>
                <tr>
                    <th>UNIDAD DE ORIGEN</th>
                    <td>{{ $unidadOrigen }}</td>
                </tr>
                <tr>
                    <th>TELÉFONO</th>
                    <td>{{ $telefono }}</td>
                </tr>
                <tr>
                    <th>CTA BANCARIA</th>
                    <td>{{ $cuenta }}</td>
                </tr>
                <tr>
                    <th>DIRECCIÓN</th>
                    <td>{{ $direccion }}</td>
                </tr>
                <tr>
                    <th>CARGO QUE OCUPA EN LA URRA</th>
                    <td class="cargo-urra">{{ $cargoUrra }}</td>
                </tr>
                <tr>
                    <th>ARMAMENTO / SERIAL</th>
                    <td>{{ $armamento }}</td>
                </tr>
                <tr>
                    <th>ULTIMO POLÍGONO</th>
                    <td>{{ $poligono }}</td>
                </tr>
            </table>
        </section>

        <section class="col-foto">
            <img src="{{ $foto }}" alt="Fotografía del funcionario">
        </section>
    </div>
</div>
</body>
</html>
