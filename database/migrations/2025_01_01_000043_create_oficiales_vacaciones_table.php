<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_vacaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia')->nullable();
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_reintegro')->nullable();
            $table->string('estatus')->nullable();
            $table->integer('is_disfrutadas')->nullable();
            $table->text('descripcion')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_vacaciones');
    }
};
