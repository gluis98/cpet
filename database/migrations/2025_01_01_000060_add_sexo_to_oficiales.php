<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales') || Schema::hasColumn('oficiales', 'sexo')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $table->enum('sexo', ['Masculino', 'Femenino'])->nullable()->after('fecha_nacimiento');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales') || ! Schema::hasColumn('oficiales', 'sexo')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn('sexo');
        });
    }
};
