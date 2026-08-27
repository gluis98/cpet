<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->string('tipo_vivienda', 30)->nullable()->after('direccion');
            $table->text('direccion_vivienda')->nullable()->after('tipo_vivienda');
        });
    }

    public function down(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn(['tipo_vivienda', 'direccion_vivienda']);
        });
    }
};
