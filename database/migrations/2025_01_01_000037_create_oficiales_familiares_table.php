<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_familiares', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia')->nullable();
            $table->string('nombre_completo');
            $table->string('parentesco', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('sexo')->nullable();
            $table->integer('edad')->nullable();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_familiares');
    }
};
