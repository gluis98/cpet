<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_familiares', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_familiares', 'discapacidad_requerimientos')) {
                $table->text('discapacidad_requerimientos')->nullable()->after('discapacidad_id');
            }
            if (! Schema::hasColumn('oficiales_familiares', 'discapacidad_observaciones')) {
                $table->text('discapacidad_observaciones')->nullable()->after('discapacidad_requerimientos');
            }
            if (! Schema::hasColumn('oficiales_familiares', 'informe_medico')) {
                $table->string('informe_medico')->nullable()->after('discapacidad_observaciones');
            }
        });
    }

    public function down(): void
    {
        Schema::table('oficiales_familiares', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('oficiales_familiares', 'informe_medico') ? 'informe_medico' : null,
                Schema::hasColumn('oficiales_familiares', 'discapacidad_observaciones') ? 'discapacidad_observaciones' : null,
                Schema::hasColumn('oficiales_familiares', 'discapacidad_requerimientos') ? 'discapacidad_requerimientos' : null,
            ]);
            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
