<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_armamento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->unsignedInteger('id_arma');
            $table->string('descripcion')->nullable();
            $table->string('estado', 50);
            $table->date('fecha_asignacion')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreign('id_arma')
                ->references('id')
                ->on('armamentos')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_armamento');
    }
};
