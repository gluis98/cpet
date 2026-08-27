<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalogo_cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::table('oficiales_cursos', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_cursos', 'catalogo_curso_id')) {
                $table->unsignedInteger('catalogo_curso_id')->nullable()->after('nombre');

                $table->foreign('catalogo_curso_id')
                    ->references('id')
                    ->on('catalogo_cursos')
                    ->nullOnDelete();
            }
        });

        if (Schema::hasTable('oficiales_cursos')) {
            $nombres = \Illuminate\Support\Facades\DB::table('oficiales_cursos')
                ->whereNotNull('nombre')
                ->where('nombre', '!=', '')
                ->distinct()
                ->pluck('nombre');

            foreach ($nombres as $nombre) {
                $catalogoId = \Illuminate\Support\Facades\DB::table('catalogo_cursos')->insertGetId([
                    'nombre' => $nombre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                \Illuminate\Support\Facades\DB::table('oficiales_cursos')
                    ->where('nombre', $nombre)
                    ->whereNull('catalogo_curso_id')
                    ->update(['catalogo_curso_id' => $catalogoId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('oficiales_cursos', function (Blueprint $table) {
            if (Schema::hasColumn('oficiales_cursos', 'catalogo_curso_id')) {
                $table->dropForeign(['catalogo_curso_id']);
                $table->dropColumn('catalogo_curso_id');
            }
        });

        Schema::dropIfExists('catalogo_cursos');
    }
};
