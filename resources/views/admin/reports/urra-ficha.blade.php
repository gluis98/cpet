<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Personal URRA — {{ $officer->nombre_completo ?? 'Funcionario' }}</title>
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
            padding: 6mm 8mm 7mm;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Cintillo horizontal, alineado a la izquierda */
        .cintillo {
            flex: 0 0 auto;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .cintillo img {
            display: block;
            height: 28mm;
            width: auto;
            max-width: 78%;
            object-fit: contain;
            object-position: left center;
        }

        .cintillo-empty {
            font-size: 11px;
            color: #64748b;
            padding: 8px 0;
        }

        .cintillo-line {
            flex: 0 0 auto;
            width: 100%;
            height: 2.2mm;
            margin-top: 1mm;
            background: linear-gradient(180deg, #e31837 0%, #b50f28 100%);
        }

        .title-bar {
            flex: 0 0 auto;
            text-align: center;
            padding: 3.5mm 0 3mm;
        }

        .title-bar h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.04em;
            color: #111;
            text-transform: uppercase;
        }

        /* Marco rojo: datos + foto */
        .frame {
            flex: 1 1 auto;
            min-height: 0;
            border: 1.8px solid #c4122f;
            display: flex;
            flex-direction: row;
            overflow: hidden;
            position: relative;
        }

        .col-datos {
            position: relative;
            flex: 1 1 56%;
            min-width: 0;
            padding: 0;
            display: flex;
            z-index: 1;
        }

        .col-datos::before {
            content: '';
            position: absolute;
            inset: 8% 12%;
            background: url('{{ asset('images/icon/logo.png') }}') center / contain no-repeat;
            opacity: 0.08;
            pointer-events: none;
            z-index: 0;
        }

        .datos-table {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            background: transparent;
        }

        .datos-table th,
        .datos-table td {
            border: 1.5px solid #111;
            padding: 2.2mm 2.5mm;
            text-align: center;
            vertical-align: middle;
            font-weight: 700;
            font-size: 12.5px;
            line-height: 1.2;
        }

        .datos-table th {
            width: 40%;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            background: #fff;
            color: #111;
        }

        .datos-table td {
            width: 60%;
            word-break: break-word;
            background: rgba(255, 255, 255, 0.72);
        }

        .datos-table tr.civ td {
            background: #b8d4f0;
        }

        .datos-table tr.dir th,
        .datos-table tr.dir td {
            height: 14%;
            padding-top: 3.5mm;
            padding-bottom: 3.5mm;
        }

        .cargo-urra {
            color: #c4122f !important;
            font-weight: 800;
            text-transform: uppercase;
        }

        .col-foto {
            flex: 0 0 42%;
            width: 42%;
            border-left: 1.5px solid #111;
            background: #111;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
            min-width: 0;
            overflow: hidden;
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
    <header class="cintillo" aria-label="Cintillo institucional">
        @if (! empty($logos))
            <img src="{{ $logos[0] }}" alt="Cintillo institucional">
        @else
            <div class="cintillo-empty">Coloque el cintillo en public/img/urra/1.png</div>
        @endif
    </header>
    <div class="cintillo-line" aria-hidden="true"></div>

    <div class="title-bar">
        <h1>FICHA PERSONAL</h1>
    </div>

    <div class="frame">
        <section class="col-datos">
            <table class="datos-table">
                <tr class="civ">
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
                <tr class="dir">
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
