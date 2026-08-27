<?php

namespace App\Support;

use App\Models\Oficiale;
use App\Models\OficialesSalud;
use Carbon\Carbon;

class ReposoEstatusSync
{
    public const VIGENTE_SI = 1;

    public const VIGENTE_NO = 0;

    public const VIGENTE_CONTINUO = 2;

    public static function esActivo(int $isVigente): bool
    {
        return in_array($isVigente, [self::VIGENTE_SI, self::VIGENTE_CONTINUO], true);
    }

    public static function etiquetaVigencia(int $isVigente): string
    {
        return match ($isVigente) {
            self::VIGENTE_SI => 'Sí',
            self::VIGENTE_CONTINUO => 'Continuo',
            default => 'No',
        };
    }

    /**
     * Finaliza reposos con fecha fin vencida y actualiza estatus del funcionario.
     */
    public static function sincronizarFinalizados(?int $idPolicia = null): void
    {
        $hoy = Carbon::today()->toDateString();

        $query = OficialesSalud::query()
            ->where('is_vigente', self::VIGENTE_SI)
            ->whereNotNull('fecha_reposo_fin')
            ->whereDate('fecha_reposo_fin', '<=', $hoy);

        if ($idPolicia !== null) {
            $query->where('id_policia', $idPolicia);
        }

        $policiasAfectados = $query->pluck('id_policia')->unique()->filter();

        $query->update(['is_vigente' => self::VIGENTE_NO]);

        foreach ($policiasAfectados as $policiaId) {
            self::actualizarEstatusFuncionario((int) $policiaId);
        }
    }

    public static function actualizarEstatusFuncionario(int $idPolicia): void
    {
        $tieneReposoActivo = OficialesSalud::where('id_policia', $idPolicia)
            ->whereIn('is_vigente', [self::VIGENTE_SI, self::VIGENTE_CONTINUO])
            ->exists();

        $oficial = Oficiale::find($idPolicia);
        if (! $oficial) {
            return;
        }

        if ($tieneReposoActivo) {
            if ($oficial->estatus !== 'En Reposo') {
                $oficial->update(['estatus' => 'En Reposo']);
            }

            return;
        }

        if ($oficial->estatus === 'En Reposo') {
            $oficial->update(['estatus' => 'Operativo']);
        }
    }
}
