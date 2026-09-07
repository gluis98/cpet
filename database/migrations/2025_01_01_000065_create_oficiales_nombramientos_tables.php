<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('catalogo_nombramientos')) {
            Schema::create('catalogo_nombramientos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre')->unique();
            });
        }

        if (! Schema::hasTable('oficiales_nombramientos')) {
            Schema::create('oficiales_nombramientos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_policia');
                $table->unsignedInteger('id_estacion');
                $table->unsignedInteger('id_tipo_nombramiento');
                $table->date('fecha_inicio')->nullable();
                $table->date('fecha_final')->nullable();
                $table->integer('is_actual')->default(0);
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

                $table->foreign('id_tipo_nombramiento')
                    ->references('id')
                    ->on('catalogo_nombramientos')
                    ->restrictOnDelete()
                    ->restrictOnUpdate();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_nombramientos');
        Schema::dropIfExists('catalogo_nombramientos');
    }
};
