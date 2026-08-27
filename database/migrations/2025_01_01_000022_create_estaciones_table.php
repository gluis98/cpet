<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('estacion')->nullable();
            $table->text('descripcion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estaciones');
    }
};
