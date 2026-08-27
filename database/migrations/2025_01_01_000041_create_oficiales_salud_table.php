<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_salud', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia')->nullable();
            $table->string('tipo_sangre', 3)->nullable();
            $table->text('alergias')->nullable();
            $table->text('condiciones_preexistentes')->nullable();
            $table->date('fecha_revision')->nullable();
            $table->text('diagnostico')->nullable();
            $table->date('fecha_reposo_inicio')->nullable();
            $table->date('fecha_reposo_fin')->nullable();
            $table->integer('dias_reposo')->nullable();
            $table->boolean('is_vigente')->default(false);

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_salud');
    }
};
