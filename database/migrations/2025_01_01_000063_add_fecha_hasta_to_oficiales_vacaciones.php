<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_vacaciones', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_vacaciones', 'fecha_hasta')) {
                $table->date('fecha_hasta')->nullable()->after('fecha_emision');
            }
        });
    }

    public function down(): void
    {
        Schema::table('oficiales_vacaciones', function (Blueprint $table) {
            if (Schema::hasColumn('oficiales_vacaciones', 'fecha_hasta')) {
                $table->dropColumn('fecha_hasta');
            }
        });
    }
};
