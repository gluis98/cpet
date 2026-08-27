<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_academico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->string('tipo_formacion')->nullable();
            $table->string('institucion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('titulo')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_academico');
    }
};
