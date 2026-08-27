<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_salud_reposos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('oficiales_salud_id')->nullable();
            $table->string('archivo')->nullable();

            $table->foreign('oficiales_salud_id')
                ->references('id')
                ->on('oficiales_salud')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_salud_reposos');
    }
};
