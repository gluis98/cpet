<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_familiares_documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->unsignedInteger('id_familiar');
            $table->enum('tipo_documento', [
                'Cédula de Identidad de los Padres',
                'Partida de Nacimiento de los Padres',
                'Acta de Matrimonio o Unión Estable de Hecho',
                'Cédula de Identidad del Cónyuge',
                'Partida de Nacimiento del Cónyuge',
                'Foto Tamaño Carnet del Cónyuge',
                'Partida de Nacimiento de los Hijos',
                'Cédula de Identidad de los Hijos',
                'Grupo Sanguíneo',
                'Nivel Educativo y Grado Académico de los Hijos',
            ]);
            $table->string('archivo_url');
            $table->timestamp('fecha_subida')->nullable()->useCurrent();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();

            $table->foreign('id_familiar')
                ->references('id')
                ->on('oficiales_familiares')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_familiares_documentos');
    }
};
