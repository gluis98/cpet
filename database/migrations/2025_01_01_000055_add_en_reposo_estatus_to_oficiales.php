<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        DB::statement("ALTER TABLE oficiales MODIFY estatus ENUM(
            'Operativo',
            'No Operativo',
            'Retirado',
            'Suspendido',
            'Jubilado',
            'Fallecido',
            'URRA',
            'En Reposo'
        ) NULL DEFAULT 'Operativo'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        DB::table('oficiales')->where('estatus', 'En Reposo')->update(['estatus' => 'No Operativo']);

        DB::statement("ALTER TABLE oficiales MODIFY estatus ENUM(
            'Operativo',
            'No Operativo',
            'Retirado',
            'Suspendido',
            'Jubilado',
            'Fallecido',
            'URRA'
        ) NULL DEFAULT 'Operativo'");
    }
};
