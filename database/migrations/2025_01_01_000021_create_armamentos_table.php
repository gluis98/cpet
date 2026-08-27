<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('tipo')->nullable();
            $table->string('calibre')->nullable();
            $table->string('origen')->nullable();
            $table->string('uso')->nullable();
            $table->string('serial')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armamentos');
    }
};
