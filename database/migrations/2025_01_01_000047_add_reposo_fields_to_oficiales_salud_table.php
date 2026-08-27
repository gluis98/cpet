<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_salud', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_salud', 'diagnostico')) {
                $table->text('diagnostico')->nullable()->after('fecha_revision');
            }
            if (! Schema::hasColumn('oficiales_salud', 'fecha_reposo_inicio')) {
                $table->date('fecha_reposo_inicio')->nullable()->after('diagnostico');
            }
            if (! Schema::hasColumn('oficiales_salud', 'fecha_reposo_fin')) {
                $table->date('fecha_reposo_fin')->nullable()->after('fecha_reposo_inicio');
            }
            if (! Schema::hasColumn('oficiales_salud', 'dias_reposo')) {
                $table->integer('dias_reposo')->nullable()->after('fecha_reposo_fin');
            }
            if (! Schema::hasColumn('oficiales_salud', 'is_vigente')) {
                $table->boolean('is_vigente')->default(false)->after('dias_reposo');
            }
        });

        if (Schema::hasColumn('oficiales_salud', 'tipo_sangre')) {
            Schema::table('oficiales_salud', function (Blueprint $table) {
                $table->string('tipo_sangre', 3)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('oficiales_salud', function (Blueprint $table) {
            $columns = ['diagnostico', 'fecha_reposo_inicio', 'fecha_reposo_fin', 'dias_reposo', 'is_vigente'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('oficiales_salud', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
