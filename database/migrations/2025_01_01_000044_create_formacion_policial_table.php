<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formacion_policial', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->string('descripcion');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formacion_policial');
    }
};
