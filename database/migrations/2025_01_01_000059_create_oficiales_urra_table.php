<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_urra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->date('fecha_inicio');
            $table->date('fecha_culminacion')->nullable();
            $table->string('tiempo_servicio')->nullable();
            $table->boolean('en_servicio')->default(false);
            $table->text('observaciones')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_urra');
    }
};
