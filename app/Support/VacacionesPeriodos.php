<?php

namespace App\Support;

use App\Models\Oficiale;
use App\Models\OficialesVacacione;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VacacionesPeriodos
{
    /**
     * Años de servicio (máximo de periodos vacacionales: 1 por año).
     */
    public static function aniosServicio(?Oficiale $oficial): int
    {
        if (! $oficial?->fecha_ingreso) {
            return 0;
        }

        $ingreso = Carbon::parse($oficial->fecha_ingreso)->startOfDay();
        $hoy = Carbon::today();

        return max(0, (int) $hoy->year - (int) $ingreso->year);
    }

    public static function anioDe(?OficialesVacacione $v): ?int
    {
        if (! $v?->fecha_emision) {
            return null;
        }

        return (int) Carbon::parse($v->fecha_emision)->format('Y');
    }

    public static function esDisfrutada(OficialesVacacione $v): bool
    {
        if (strtoupper(trim((string) $v->estatus)) === 'NEGADAS') {
            return false;
        }

        return (int) $v->is_disfrutadas === 1;
    }

    public static function esVencida(OficialesVacacione $v): bool
    {
        if (self::esDisfrutada($v)) {
            return false;
        }

        return strtoupper(trim((string) $v->estatus)) === 'VENCIDAS';
    }

    /**
     * Prioridad para conservar un único registro por año.
     */
    public static function score(OficialesVacacione $v): int
    {
        if (self::esDisfrutada($v)) {
            return 300;
        }
        if (self::esVencida($v)) {
            return 200;
        }
        if (strtoupper(trim((string) $v->estatus)) === 'NEGADAS') {
            return 50;
        }

        return 100;
    }

    /**
     * Elimina duplicados por año de emisión para un funcionario. Conserva el mejor registro.
     */
    public static function dedupeOficial(int $idPolicia, ?int $soloAnio = null): int
    {
        $query = OficialesVacacione::query()
            ->where('id_policia', $idPolicia)
            ->whereNotNull('fecha_emision');

        if ($soloAnio !== null) {
            $query->whereYear('fecha_emision', $soloAnio);
        }

        $grupos = $query->orderByDesc('id')->get()->groupBy(fn ($v) => self::anioDe($v));

        $deleted = 0;
        foreach ($grupos as $anio => $rows) {
            if ($anio === null || $rows->count() <= 1) {
                continue;
            }

            $ordenadas = $rows->sort(function ($a, $b) {
                $cmp = self::score($b) <=> self::score($a);
                if ($cmp !== 0) {
                    return $cmp;
                }

                return $b->id <=> $a->id;
            })->values();

            $keepId = $ordenadas->first()->id;
            $deleteIds = $ordenadas->skip(1)->pluck('id')->all();
            if ($deleteIds !== []) {
                $deleted += OficialesVacacione::whereIn('id', $deleteIds)->delete();
            }

            // Evitar warning de variable no usada en análisis estático.
            unset($keepId);
        }

        return $deleted;
    }

    /**
     * Conteos por año único (no por filas).
     *
     * @return array{
     *   anios_servicio: int,
     *   disfrutadas: int,
     *   vencidas: int,
     *   total: int,
     *   anios_disfrutados: list<int>,
     *   anios_vencidos: list<int>,
     *   anios_no_disfrutados: list<int>
     * }
     */
    public static function resumen(?Oficiale $oficial, ?Collection $vacaciones = null): array
    {
        $aniosServicio = self::aniosServicio($oficial);

        if (! $oficial) {
            return [
                'anios_servicio' => 0,
                'disfrutadas' => 0,
                'vencidas' => 0,
                'total' => 0,
                'anios_disfrutados' => [],
                'anios_vencidos' => [],
                'anios_no_disfrutados' => [],
            ];
        }

        $vacaciones ??= OficialesVacacione::query()
            ->where('id_policia', $oficial->id)
            ->whereNotNull('fecha_emision')
            ->get();

        // Una fila por año (la de mayor score).
        $porAnio = [];
        foreach ($vacaciones as $v) {
            $anio = self::anioDe($v);
            if ($anio === null) {
                continue;
            }
            if (! isset($porAnio[$anio]) || self::score($v) > self::score($porAnio[$anio])
                || (self::score($v) === self::score($porAnio[$anio]) && $v->id > $porAnio[$anio]->id)) {
                $porAnio[$anio] = $v;
            }
        }

        $disfrutados = [];
        $vencidos = [];
        foreach ($porAnio as $anio => $v) {
            if (self::esDisfrutada($v)) {
                $disfrutados[] = (int) $anio;
            } elseif (self::esVencida($v)) {
                $vencidos[] = (int) $anio;
            }
        }
        sort($disfrutados);
        sort($vencidos);

        $setDisfrutados = array_fill_keys($disfrutados, true);
        $ingresoYear = $oficial->fecha_ingreso
            ? (int) Carbon::parse($oficial->fecha_ingreso)->format('Y')
            : null;
        $anioFin = (int) Carbon::now()->format('Y');
        $noDisfrutados = [];
        if ($ingresoYear !== null && $aniosServicio > 0) {
            // Exactamente N años de servicio (1 periodo por año), alineados al año actual.
            $anioInicioPeriodos = max($ingresoYear, $anioFin - $aniosServicio + 1);
            for ($y = $anioInicioPeriodos; $y <= $anioFin; $y++) {
                if (! isset($setDisfrutados[$y])) {
                    $noDisfrutados[] = $y;
                }
            }
        }

        return [
            'anios_servicio' => $aniosServicio,
            'disfrutadas' => count($disfrutados),
            'vencidas' => count($vencidos),
            'total' => count($porAnio),
            'anios_disfrutados' => $disfrutados,
            'anios_vencidos' => $vencidos,
            'anios_no_disfrutados' => $noDisfrutados,
        ];
    }
}
