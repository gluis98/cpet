<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->boolean('sabe_conducir')->default(false)->after('direccion_vivienda');
            $table->json('tipos_conduccion')->nullable()->after('sabe_conducir');
        });
    }

    public function down(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn(['sabe_conducir', 'tipos_conduccion']);
        });
    }
};
