<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_icap_expedientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->text('causa')->nullable();
            $table->text('resulta')->nullable();
            $table->text('culminacion_proceso')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });

        Schema::create('oficiales_icap_sobrevivientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->text('observaciones')->nullable();
            $table->text('resulta')->nullable();
            $table->text('culminacion_proceso')->nullable();
            $table->string('copia_digitalizada')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_icap_sobrevivientes');
        Schema::dropIfExists('oficiales_icap_expedientes');
    }
};
