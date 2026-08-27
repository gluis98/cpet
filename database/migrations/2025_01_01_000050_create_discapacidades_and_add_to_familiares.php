<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discapacidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::table('oficiales_familiares', function (Blueprint $table) {
            $table->boolean('posee_discapacidad')->default(false)->after('edad');
            $table->unsignedInteger('discapacidad_id')->nullable()->after('posee_discapacidad');

            $table->foreign('discapacidad_id')
                ->references('id')
                ->on('discapacidades')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('oficiales_familiares', function (Blueprint $table) {
            $table->dropForeign(['discapacidad_id']);
            $table->dropColumn(['posee_discapacidad', 'discapacidad_id']);
        });

        Schema::dropIfExists('discapacidades');
    }
};
