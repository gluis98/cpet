<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('descripcion', 100);
            $table->unsignedSmallInteger('estado_id');

            $table->foreign('estado_id')
                ->references('id')
                ->on('estados')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
