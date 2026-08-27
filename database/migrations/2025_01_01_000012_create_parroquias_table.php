<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parroquias', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('descripcion', 50);
            $table->unsignedSmallInteger('municipio_id')->default(0);
            $table->unsignedInteger('atencionfamilias');

            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipios')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parroquias');
    }
};
