<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_radiograma', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->unsignedInteger('id_estacion');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->integer('is_actual');
            $table->string('descripcion')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreign('id_estacion')
                ->references('id')
                ->on('estaciones')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_radiograma');
    }
};
