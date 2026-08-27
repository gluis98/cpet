<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha URRA — {{ $officer->nombre_completo ?? 'Funcionario' }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 16px;
            font-family: Arial, Helvetica, sans-serif;
            color: #0f2744;
            background: #e8eef5;
        }
        .sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 8px 30px rgba(15, 39, 68, 0.12);
            display: flex;
            flex-direction: column;
        }
        .cintillo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 14px 18px;
            border-bottom: 3px solid #1a4574;
            background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
        }
        .cintillo img {
            max-height: 72px;
            max-width: 120px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .cintillo-empty {
            font-size: 12px;
            color: #64748b;
            text-align: center;
            width: 100%;
            padding: 8px 0;
        }
        .title-bar {
            text-align: center;
            padding: 12px 16px 4px;
        }
        .title-bar h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.04em;
            color: #0f2744;
        }
        .title-bar p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #64748b;
        }
        .body-grid {
            flex: 1;
            display: flex;
            min-height: 0;
            border-top: 1px solid #e2e8f0;
        }
        .col-datos {
            flex: 1 1 55%;
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .col-foto {
            flex: 1 1 45%;
            border-left: 1px solid #e2e8f0;
            background: #0f2744;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
            min-height: 420px;
            padding: 0;
        }
        .col-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 4px;
        }
        .field .value {
            font-size: 15px;
            font-weight: 600;
            color: #0f2744;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
            min-height: 1.4em;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-si { background: #dcfce7; color: #166534; }
        .badge-no { background: #e2e8f0; color: #475569; }
        .actions {
            text-align: center;
            margin: 14px auto;
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
        @media print {
            body { background: #fff; padding: 0; }
            .sheet { box-shadow: none; width: 100%; min-height: 100vh; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
@php
    $foto = ($officer && $officer->fotografia)
        ? asset('storage/'.$officer->fotografia)
        : asset('images/oficial-icon.png');
    $fmt = fn ($d) => $d ? \Carbon\Carbon::parse($d)->format('d/m/Y') : '—';
@endphp

<div class="actions">
    <button type="button" onclick="window.print()">Imprimir ficha</button>
</div>

<div class="sheet">
    <div class="cintillo">
        @forelse ($logos as $logo)
            <img src="{{ $logo }}" alt="Logo URRA">
        @empty
            <div class="cintillo-empty">Coloque los logos numerados (1.png, 2.png…) en <code>public/img/urra</code></div>
        @endforelse
    </div>

    <div class="title-bar">
        <h1>FICHA URRA</h1>
        <p>Unidad de Respuesta Rápida / Asignación de servicio</p>
    </div>

    <div class="body-grid">
        <div class="col-datos">
            <div class="field">
                <label>Nombre completo</label>
                <div class="value">{{ $officer->nombre_completo ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Documento de identidad</label>
                <div class="value">{{ $officer->documento_identidad ?? '—' }}</div>
            </div>
            <div class="field">
                <label>N° de placa / credencial</label>
                <div class="value">{{ $officer->numero_placa ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Tipo de funcionario</label>
                <div class="value">{{ $officer->tipo_funcionario ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Cargo</label>
                <div class="value">{{ $officer->cargos_administrativo->nombre_cargo ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Día de inicio</label>
                <div class="value">{{ $fmt($urra->fecha_inicio) }}</div>
            </div>
            <div class="field">
                <label>Día de culminación</label>
                <div class="value">{{ $fmt($urra->fecha_culminacion) }}</div>
            </div>
            <div class="field">
                <label>Tiempo de servicio</label>
                <div class="value">{{ $urra->tiempo_servicio ?: '—' }}</div>
            </div>
            <div class="field">
                <label>Actualmente en servicio</label>
                <div class="value">
                    @if ($urra->en_servicio)
                        <span class="badge badge-si">Sí</span>
                    @else
                        <span class="badge badge-no">No</span>
                    @endif
                </div>
            </div>
            @if ($urra->observaciones)
                <div class="field">
                    <label>Observaciones</label>
                    <div class="value">{{ $urra->observaciones }}</div>
                </div>
            @endif
        </div>
        <div class="col-foto">
            <img src="{{ $foto }}" alt="Fotografía del funcionario">
        </div>
    </div>
</div>
</body>
</html>
