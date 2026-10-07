<?php

namespace App\Console\Commands;

use App\Models\OficialesVacacione;
use Illuminate\Console\Command;

class WipeVacaciones extends Command
{
    protected $signature = 'vacaciones:wipe {--force : Ejecutar sin confirmación}';

    protected $description = 'Elimina todas las vacaciones de la base de datos para recargarlas';

    public function handle(): int
    {
        $total = OficialesVacacione::query()->count();

        if ($total === 0) {
            $this->info('No hay vacaciones registradas.');

            return self::SUCCESS;
        }

        if (! $this->option('force')) {
            if (! $this->confirm("Se eliminarán {$total} registro(s) de vacaciones. ¿Continuar?")) {
                $this->warn('Operación cancelada.');

                return self::FAILURE;
            }
        }

        OficialesVacacione::query()->delete();

        $this->info("Se eliminaron {$total} registro(s) de vacaciones.");

        return self::SUCCESS;
    }
};
