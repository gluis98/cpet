<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_cursos', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_cursos', 'duracion_valor')) {
                $table->unsignedSmallInteger('duracion_valor')->nullable()->after('fecha_inicio');
            }
            if (! Schema::hasColumn('oficiales_cursos', 'duracion_tipo')) {
                $table->enum('duracion_tipo', ['Años', 'Meses', 'Horas'])->nullable()->after('duracion_valor');
            }
        });
    }

    public function down(): void
    {
        Schema::table('oficiales_cursos', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('oficiales_cursos', 'duracion_tipo') ? 'duracion_tipo' : null,
                Schema::hasColumn('oficiales_cursos', 'duracion_valor') ? 'duracion_valor' : null,
            ]);
            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
