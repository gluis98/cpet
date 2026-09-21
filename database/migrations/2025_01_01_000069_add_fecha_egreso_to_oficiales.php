<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        if (! Schema::hasColumn('oficiales', 'fecha_egreso')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $table->date('fecha_egreso')->nullable()->after('fecha_ingreso');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales') || ! Schema::hasColumn('oficiales', 'fecha_egreso')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn('fecha_egreso');
        });
    }
};
