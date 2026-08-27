<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_reconocimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->string('descripcion');
            $table->date('fecha');
            $table->string('autoridad')->nullable();
            $table->string('tipo')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_reconocimientos');
    }
};
