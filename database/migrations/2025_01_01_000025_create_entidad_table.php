<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entidad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('director_general')->nullable();
            $table->string('rrhh')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entidad');
    }
};
