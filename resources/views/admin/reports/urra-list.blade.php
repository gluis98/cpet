<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            color: #0f2744;
            background: #e8eef5;
        }
        .wrap {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(15, 39, 68, 0.1);
        }
        h1 { margin: 0 0 4px; font-size: 22px; }
        .subtitle { margin: 0 0 18px; color: #64748b; font-size: 13px; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #dbe3ee;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #0f2744;
            color: #fff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        tr:nth-child(even) td { background: #f8fafc; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-si { background: #dcfce7; color: #166534; }
        .badge-no { background: #e2e8f0; color: #475569; }
        .actions { text-align: center; margin-bottom: 14px; }
        .actions button {
            border: 0;
            background: #1a4574;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }
        .empty { text-align: center; color: #64748b; padding: 24px; }
        @media print {
            body { background: #fff; padding: 0; }
            .wrap { box-shadow: none; border-radius: 0; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
<div class="actions">
    <button type="button" onclick="window.print()">Imprimir reporte</button>
</div>

<div class="wrap">
    <h1>{{ $title }}</h1>
    <p class="subtitle">{{ $subtitle }} · Generado el {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Placa</th>
                <th>Inicio</th>
                <th>Culminación</th>
                <th>Tiempo</th>
                <th>En servicio</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registros as $row)
                <tr>
                    <td>{{ $row->oficiale->documento_identidad ?? '—' }}</td>
                    <td>{{ $row->oficiale->nombre_completo ?? '—' }}</td>
                    <td>{{ $row->oficiale->numero_placa ?? '—' }}</td>
                    <td>{{ $row->fecha_inicio ? \Carbon\Carbon::parse($row->fecha_inicio)->format('d/m/Y') : '—' }}</td>
                    <td>{{ $row->fecha_culminacion ? \Carbon\Carbon::parse($row->fecha_culminacion)->format('d/m/Y') : '—' }}</td>
                    <td>{{ $row->tiempo_servicio ?: '—' }}</td>
                    <td>
                        @if ($row->en_servicio)
                            <span class="badge badge-si">Sí</span>
                        @else
                            <span class="badge badge-no">No</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">No hay registros para este reporte.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
