<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte filtrado de funcionarios</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 16px; background: #e8eef5; color: #0f2744; }
        .wrap { max-width: 1200px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 8px 24px rgba(15,39,68,.1); }
        h1 { margin: 0 0 6px; font-size: 22px; }
        .meta { font-size: 13px; color: #64748b; margin-bottom: 16px; }
        .filtros { margin: 0 0 16px; padding: 0; list-style: none; display: flex; flex-wrap: wrap; gap: 6px; }
        .filtros li { background: #eef4fb; color: #1a4574; font-size: 12px; padding: 4px 10px; border-radius: 999px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th, td { border: 1px solid #dbe3ee; padding: 6px 8px; text-align: left; vertical-align: top; }
        th { background: #0f2744; color: #fff; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) td { background: #f8fafc; }
        .actions { text-align: center; margin-bottom: 14px; }
        .actions button { border: 0; background: #1a4574; color: #fff; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .empty { text-align: center; padding: 24px; color: #64748b; }
        @media print { body { background: #fff; padding: 0; } .wrap { box-shadow: none; } .actions { display: none; } }
    </style>
</head>
<body>
<div class="actions">
    <button type="button" onclick="window.print()">Imprimir reporte</button>
</div>

<div class="wrap">
    <h1>Reporte de funcionarios — filtros avanzados</h1>
    <p class="meta">Generado el {{ now()->format('d/m/Y H:i') }} · {{ $oficiales->count() }} registro(s)</p>

    @if (! empty($filtros))
        <ul class="filtros">
            @foreach ($filtros as $f)
                <li>{{ $f }}</li>
            @endforeach
        </ul>
    @else
        <p class="meta">Sin filtros aplicados (listado completo).</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Sexo</th>
                <th>Tipo sangre</th>
                <th>Estado civil</th>
                <th>Hijos</th>
                <th>Tipo funcionario</th>
                <th>Cargo</th>
                <th>Jerarquía</th>
                <th>Estatus</th>
                <th>Formación</th>
                <th>Vivienda</th>
                <th>Conduce</th>
                <th>Tipos conducción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($oficiales as $o)
                @php
                    $jerarquia = $o->oficiales_cargos->first()?->cargo?->nombre_cargo ?? '—';
                    $formacion = $o->oficiales_academicos->first()?->tipo_formacion ?? '—';
                    $tiposCond = is_array($o->tipos_conduccion) ? implode(', ', $o->tipos_conduccion) : '—';
                @endphp
                <tr>
                    <td>{{ $o->documento_identidad }}</td>
                    <td>{{ $o->nombre_completo }}</td>
                    <td>{{ $o->sexo ?? '—' }}</td>
                    <td>{{ $o->tipo_sangre ?? '—' }}</td>
                    <td>{{ $o->estado_civil ?? '—' }}</td>
                    <td>{{ $o->hijos_count ?? 0 }}</td>
                    <td>{{ $o->tipo_funcionario ?? '—' }}</td>
                    <td>{{ $o->cargos_administrativo->nombre_cargo ?? '—' }}</td>
                    <td>{{ $jerarquia }}</td>
                    <td>{{ $o->estatus ?? '—' }}</td>
                    <td>{{ $formacion }}</td>
                    <td>{{ $o->tipo_vivienda ?? '—' }}</td>
                    <td>{{ $o->sabe_conducir ? 'Sí' : 'No' }}</td>
                    <td>{{ $o->sabe_conducir ? $tiposCond : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="14" class="empty">No hay funcionarios que coincidan con los filtros.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
