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

        Schema::table('oficiales', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales', 'tipo_vivienda')) {
                $table->string('tipo_vivienda', 30)->nullable()->after('direccion');
            }
            if (! Schema::hasColumn('oficiales', 'direccion_vivienda')) {
                $table->text('direccion_vivienda')->nullable()->after('tipo_vivienda');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('oficiales', 'tipo_vivienda')) {
                $columns[] = 'tipo_vivienda';
            }
            if (Schema::hasColumn('oficiales', 'direccion_vivienda')) {
                $columns[] = 'direccion_vivienda';
            }
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
