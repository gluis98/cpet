<?php

namespace App\Support;

use App\Models\Oficiale;
use App\Models\OficialesUrra;
use Carbon\Carbon;

class UrraEstatusSync
{
    /**
     * Si la fecha de culminación ya pasó, marcar en_servicio = false.
     */
    public static function sincronizarVencidos(?int $idPolicia = null): void
    {
        $hoy = Carbon::today()->toDateString();

        $query = OficialesUrra::query()
            ->where('en_servicio', true)
            ->whereNotNull('fecha_culminacion')
            ->whereDate('fecha_culminacion', '<=', $hoy);

        if ($idPolicia !== null) {
            $query->where('id_policia', $idPolicia);
        }

        $afectados = $query->pluck('id_policia')->unique()->filter();

        $query->update(['en_servicio' => false]);

        foreach ($afectados as $policiaId) {
            self::actualizarEstatusFuncionario((int) $policiaId);
        }
    }

    public static function actualizarEstatusFuncionario(int $idPolicia): void
    {
        $tieneUrraActiva = OficialesUrra::where('id_policia', $idPolicia)
            ->where('en_servicio', true)
            ->exists();

        $oficial = Oficiale::find($idPolicia);
        if (! $oficial) {
            return;
        }

        if ($tieneUrraActiva) {
            if ($oficial->estatus !== 'URRA') {
                $oficial->update(['estatus' => 'URRA']);
            }

            return;
        }

        if ($oficial->estatus === 'URRA') {
            $oficial->update(['estatus' => 'Operativo']);
        }
    }
}
