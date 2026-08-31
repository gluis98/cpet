@extends('layouts.app')

@section('content')
<div class="space-y-7">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-brand-600">Panel principal</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Dashboard</h1>
            <p class="mt-1.5 text-sm text-slate-500">Resumen operativo del sistema de gestión de personal</p>
        </div>
        <div class="rounded-xl border border-brand-100 bg-brand-50 px-4 py-2 text-xs font-medium text-brand-800">
            <i class="fas fa-calendar-day mr-1.5 text-accent-500"></i>
            {{ now()->locale('es')->isoFormat('dddd D [de] MMMM YYYY') }}
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500 p-5 text-white shadow-lg shadow-brand-900/20">
            <div class="absolute -right-6 -top-6 h-28 w-28 rounded-full bg-white/10"></div>
            <p class="relative text-xs font-semibold uppercase tracking-wider text-white/70">Total funcionarios</p>
            <p class="relative mt-3 text-3xl font-bold tabular-nums">{{ number_format($totalOfficers, 0, '', '.') }}</p>
            @include('partials.dashboard-tipo-breakdown', ['counts' => $totalPorTipo])
            <p class="relative mt-1 text-sm text-white/70">Registrados en el sistema</p>
            <i class="fas fa-users absolute bottom-3 right-4 text-4xl text-white/15"></i>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-emerald-600 to-teal-500 p-5 text-white shadow-lg shadow-emerald-900/15">
            <div class="absolute -right-6 -top-6 h-28 w-28 rounded-full bg-white/10"></div>
            <p class="relative text-xs font-semibold uppercase tracking-wider text-white/70">Operativos</p>
            <p class="relative mt-3 text-3xl font-bold tabular-nums">{{ number_format($operativos, 0, '', '.') }}</p>
            @include('partials.dashboard-tipo-breakdown', ['counts' => $operativosPorTipo])
            <p class="relative mt-1 text-sm text-white/70">En servicio activo</p>
            <i class="fas fa-user-check absolute bottom-3 right-4 text-4xl text-white/15"></i>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-800 via-accent-600 to-accent-400 p-5 text-white shadow-lg shadow-amber-900/15">
            <div class="absolute -right-6 -top-6 h-28 w-28 rounded-full bg-white/10"></div>
            <p class="relative text-xs font-semibold uppercase tracking-wider text-white/70">En reposo</p>
            <p class="relative mt-3 text-3xl font-bold tabular-nums">{{ number_format($funcionariosReposo->count(), 0, '', '.') }}</p>
            @include('partials.dashboard-tipo-breakdown', ['counts' => $reposoPorTipo])
            <p class="relative mt-1 text-sm text-white/70">Reposos médicos vigentes</p>
            <i class="fas fa-bed absolute bottom-3 right-4 text-4xl text-white/15"></i>
        </div>

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-900 via-sky-700 to-cyan-500 p-5 text-white shadow-lg shadow-sky-900/15">
            <div class="absolute -right-6 -top-6 h-28 w-28 rounded-full bg-white/10"></div>
            <p class="relative text-xs font-semibold uppercase tracking-wider text-white/70">Radiogramas</p>
            <p class="relative mt-3 text-3xl font-bold tabular-nums">{{ number_format($funcionariosServicio->count(), 0, '', '.') }}</p>
            <p class="relative mt-1 text-sm text-white/70">Asignaciones activas</p>
            <i class="fas fa-broadcast-tower absolute bottom-3 right-4 text-4xl text-white/15"></i>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md shadow-slate-200/50">
            <header class="flex items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white px-5 py-3.5">
                <h2 class="text-sm font-semibold text-slate-800">
                    <i class="fas fa-heartbeat mr-2 text-amber-600"></i>Funcionarios en reposo médico
                </h2>
                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800">{{ $funcionariosReposo->count() }}</span>
            </header>
            <div class="max-h-96 overflow-auto">
                @if($funcionariosReposo->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="sticky top-0 bg-white text-left text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Funcionario</th>
                                <th class="px-4 py-3 font-semibold">Diagnóstico</th>
                                <th class="px-4 py-3 font-semibold">Fin</th>
                                <th class="px-4 py-3 font-semibold">Días</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($funcionariosReposo as $reposo)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-800">{{ $reposo->oficiale->nombre_completo }}</p>
                                    <p class="text-xs text-slate-500">{{ $reposo->oficiale->documento_identidad }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ Str::limit($reposo->diagnostico, 30) }}</td>
                                <td class="px-4 py-3 tabular-nums @if($reposo->fecha_reposo_fin){{ \Carbon\Carbon::parse($reposo->fecha_reposo_fin)->isPast() ? 'text-red-600 font-semibold' : 'text-emerald-700 font-medium' }}@else text-slate-500 @endif">
                                    @if($reposo->fecha_reposo_fin)
                                        {{ \Carbon\Carbon::parse($reposo->fecha_reposo_fin)->format('d/m/Y') }}
                                    @elseif((int) $reposo->is_vigente === 2)
                                        Continuo
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-800">{{ $reposo->dias_reposo ?? '—' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-4 py-14 text-center text-slate-400">
                        <i class="fas fa-smile mb-3 text-3xl opacity-40"></i>
                        <p class="text-sm">No hay funcionarios en reposo</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md shadow-slate-200/50">
            <header class="flex items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-sky-50 to-white px-5 py-3.5">
                <h2 class="text-sm font-semibold text-slate-800">
                    <i class="fas fa-broadcast-tower mr-2 text-sky-600"></i>Asignaciones de servicio
                </h2>
                <span class="rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-bold text-sky-800">{{ $funcionariosServicio->count() }}</span>
            </header>
            <div class="max-h-96 overflow-auto">
                @if($funcionariosServicio->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="sticky top-0 bg-white text-left text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Funcionario</th>
                                <th class="px-4 py-3 font-semibold">Estación</th>
                                <th class="px-4 py-3 font-semibold">Inicio</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($funcionariosServicio as $servicio)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-800">{{ $servicio->oficiale->nombre_completo }}</p>
                                    <p class="text-xs text-slate-500">{{ $servicio->oficiale->documento_identidad }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-sky-50 px-2.5 py-0.5 text-xs font-semibold text-sky-800">{{ $servicio->estacione->estacion }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-600 tabular-nums">
                                    {{ \Carbon\Carbon::parse($servicio->fecha_inicio)->format('d/m/Y') }}
                                    <span class="block text-xs text-slate-400">{{ \Carbon\Carbon::parse($servicio->fecha_inicio)->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-4 py-14 text-center text-slate-400">
                        <i class="fas fa-inbox mb-3 text-3xl opacity-40"></i>
                        <p class="text-sm">No hay radiogramas activos</p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    @if($notificaciones->count() > 0)
    <section class="rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm">
        <h2 class="text-sm font-bold text-amber-900">
            <i class="fas fa-exclamation-triangle mr-2 text-accent-500"></i>Reincorporaciones próximas
        </h2>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            @foreach($notificaciones as $notif)
            <div class="rounded-xl border border-amber-100 bg-white px-4 py-3 shadow-sm">
                <p class="font-semibold text-slate-800">{{ $notif->oficiale->nombre_completo }}</p>
                <p class="mt-1 text-xs text-slate-500">
                    Se reincorpora mañana ({{ \Carbon\Carbon::parse($notif->fecha_reposo_fin)->format('d/m/Y') }})
                </p>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        setTimeout(function () { location.reload(); }, 300000);
    });
</script>
@endsection
