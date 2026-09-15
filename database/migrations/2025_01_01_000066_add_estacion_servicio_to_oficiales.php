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

        if (! Schema::hasColumn('oficiales', 'id_estacion_servicio')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $table->unsignedInteger('id_estacion_servicio')->nullable()->after('cargo_administrativo_id');

                $table->foreign('id_estacion_servicio')
                    ->references('id')
                    ->on('estaciones')
                    ->nullOnDelete()
                    ->restrictOnUpdate();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales') || ! Schema::hasColumn('oficiales', 'id_estacion_servicio')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropForeign(['id_estacion_servicio']);
            $table->dropColumn('id_estacion_servicio');
        });
    }
};
