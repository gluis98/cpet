<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_academico', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_academico', 'documento_fondo_negro')) {
                $table->string('documento_fondo_negro')->nullable()->after('titulo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('oficiales_academico', function (Blueprint $table) {
            if (Schema::hasColumn('oficiales_academico', 'documento_fondo_negro')) {
                $table->dropColumn('documento_fondo_negro');
            }
        });
    }
};
