<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de familiares</title>
    <style>
        :root {
            --brand-900: #0f2744;
            --brand-700: #1a4574;
            --brand-50: #eef4fb;
            --accent: #c4922e;
            --slate-500: #64748b;
            --slate-200: #e2e8f0;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 20px;
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
            background: linear-gradient(160deg, #e8eef5 0%, #f8fafc 45%, #eef2f7 100%);
            color: var(--brand-900);
            line-height: 1.45;
        }

        .toolbar {
            max-width: 1100px;
            margin: 0 auto 16px;
            text-align: center;
        }

        .toolbar button {
            border: 0;
            background: linear-gradient(135deg, var(--brand-700), var(--brand-900));
            color: #fff;
            padding: 11px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(15, 39, 68, 0.25);
        }

        .report {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(15, 39, 68, 0.12);
        }

        .report__hero {
            background: linear-gradient(135deg, var(--brand-900) 0%, var(--brand-700) 55%, #2f6fad 100%);
            color: #fff;
            padding: 28px 32px 24px;
            position: relative;
        }

        .report__hero::after {
            content: "";
            position: absolute;
            right: -40px;
            top: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .report__hero-inner {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            position: relative;
            z-index: 1;
        }

        .report__logo {
            width: 72px;
            height: 72px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 14px;
            padding: 8px;
        }

        .report__hero h1 {
            margin: 0 0 4px;
            font-size: 1.55rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .report__hero p {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.88;
        }

        .report__meta {
            padding: 18px 32px;
            border-bottom: 1px solid var(--slate-200);
            background: #fafbfd;
        }

        .report__meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
        }

        .report__meta time {
            font-size: 0.8125rem;
            color: var(--slate-500);
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .stat {
            background: var(--brand-50);
            border: 1px solid #d4e3f4;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 0.8125rem;
        }

        .stat strong {
            display: block;
            font-size: 1.125rem;
            color: var(--brand-700);
            line-height: 1.2;
        }

        .filtros {
            margin: 12px 0 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .filtros li {
            background: #fff;
            border: 1px solid #c9d5e3;
            color: var(--brand-700);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 999px;
        }

        .report__body {
            padding: 24px 32px 32px;
        }

        .officer-block {
            margin-bottom: 28px;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            overflow: hidden;
        }

        .officer-block:last-child {
            margin-bottom: 0;
        }

        .officer-block__head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 14px 18px;
            background: linear-gradient(90deg, var(--brand-50), #fff);
            border-bottom: 1px solid var(--slate-200);
        }

        .officer-block__head h2 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: var(--brand-900);
        }

        .officer-block__head span {
            font-size: 0.8125rem;
            color: var(--slate-500);
        }

        .badge-count {
            background: var(--brand-900);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }

        thead th {
            background: var(--brand-900);
            color: #fff;
            text-align: left;
            padding: 10px 14px;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: top;
        }

        tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .tag {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .tag--m { background: #dbeafe; color: #1e40af; }
        .tag--f { background: #fce7f3; color: #9d174d; }
        .tag--disc { background: #fef3c7; color: #92400e; }

        .empty {
            text-align: center;
            padding: 48px 24px;
            color: var(--slate-500);
        }

        .empty i {
            font-size: 2rem;
            opacity: 0.35;
            display: block;
            margin-bottom: 12px;
        }

        .report__footer {
            padding: 16px 32px 24px;
            border-top: 1px solid var(--slate-200);
            text-align: center;
            font-size: 0.75rem;
            color: var(--slate-500);
        }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none; }
            .report { box-shadow: none; border-radius: 0; max-width: none; }
            .officer-block { break-inside: avoid; }
        }

        @media (max-width: 640px) {
            body { padding: 10px; }
            .report__hero, .report__meta, .report__body { padding-left: 16px; padding-right: 16px; }
            .report__hero-inner { flex-direction: column; }
            table { font-size: 0.75rem; }
            thead th, tbody td { padding: 8px 10px; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="toolbar no-print">
        <button type="button" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimir reporte
        </button>
    </div>

    <article class="report">
        <header class="report__hero">
            <div class="report__hero-inner">
                <img class="report__logo" src="{{ public_asset('images/icon/logo.png') }}" alt="Logo">
                <div>
                    <h1>Reporte de familiares</h1>
                    <p>Cuerpo de Policía del Estado Trujillo — CPET</p>
                    @if (! empty($entidad?->director_general))
                        <p>Director general: {{ $entidad->director_general }}</p>
                    @endif
                </div>
            </div>
        </header>

        <div class="report__meta">
            <div class="report__meta-row">
                <time datetime="{{ now()->toIso8601String() }}">
                    Generado el {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY, HH:mm') }}
                </time>
                <div class="stats">
                    <div class="stat">
                        <strong>{{ $oficiales->count() }}</strong>
                        Funcionarios
                    </div>
                    <div class="stat">
                        <strong>{{ $totalFamiliares }}</strong>
                        Familiares
                    </div>
                </div>
            </div>
            @if (! empty($filtros))
                <ul class="filtros">
                    @foreach ($filtros as $filtro)
                        <li>{{ $filtro }}</li>
                    @endforeach
                </ul>
            @else
                <ul class="filtros">
                    <li>Sin filtros — todos los familiares registrados</li>
                </ul>
            @endif
        </div>

        <div class="report__body">
            @forelse ($oficiales as $officer)
                <section class="officer-block">
                    <div class="officer-block__head">
                        <div>
                            <h2>{{ $officer->nombre_completo }}</h2>
                            <span>Cédula: {{ $officer->documento_identidad }}</span>
                        </div>
                        <span class="badge-count">{{ $officer->oficiales_familiares->count() }} familiar(es)</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Parentesco</th>
                                <th>Fecha nac.</th>
                                <th>Sexo</th>
                                <th>Edad</th>
                                <th>Discapacidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($officer->oficiales_familiares as $family)
                                @php
                                    $edad = $family->fecha_nacimiento
                                        ? \Carbon\Carbon::parse($family->fecha_nacimiento)->age
                                        : $family->edad;
                                @endphp
                                <tr>
                                    <td><strong>{{ $family->nombre_completo }}</strong></td>
                                    <td>{{ $family->parentesco }}</td>
                                    <td>
                                        @if ($family->fecha_nacimiento)
                                            {{ \Carbon\Carbon::parse($family->fecha_nacimiento)->format('d/m/Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if ($family->sexo === 'M')
                                            <span class="tag tag--m">Masculino</span>
                                        @elseif ($family->sexo === 'F')
                                            <span class="tag tag--f">Femenino</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $edad !== null ? $edad.' años' : '—' }}</td>
                                    <td>
                                        @if ($family->posee_discapacidad)
                                            <span class="tag tag--disc">{{ $family->discapacidade->nombre ?? 'Sí' }}</span>
                                        @else
                                            No
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            @empty
                <div class="empty">
                    <i class="fas fa-users-slash"></i>
                    <p>No se encontraron familiares con los filtros seleccionados.</p>
                </div>
            @endforelse
        </div>

        <footer class="report__footer">
            Sistema de gestión CPET · Reporte generado automáticamente
        </footer>
    </article>
</body>
</html>
