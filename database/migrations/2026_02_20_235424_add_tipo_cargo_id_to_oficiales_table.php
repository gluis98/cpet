<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_cargo_id')->nullable()->after('cargo_administrativo_id');
            $table->foreign('tipo_cargo_id')->references('id')->on('tipos_cargos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropForeign(['tipo_cargo_id']);
            $table->dropColumn('tipo_cargo_id');
        });
    }
};
