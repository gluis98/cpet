<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Si un intento anterior dejó la tabla a medias (tipos incompatibles), recrearla.
        if (Schema::hasTable('centros_votacion')) {
            if (Schema::hasColumn('oficiales', 'centro_votacion_id')) {
                Schema::table('oficiales', function (Blueprint $table) {
                    try {
                        $table->dropForeign(['centro_votacion_id']);
                    } catch (\Throwable $e) {
                        // ignore
                    }
                    $table->dropColumn('centro_votacion_id');
                });
            }
            Schema::dropIfExists('centros_votacion');
        }

        Schema::create('centros_votacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            // municipios.id y parroquias.id son SMALLINT UNSIGNED
            $table->unsignedSmallInteger('municipio_id');
            $table->unsignedSmallInteger('parroquia_id');

            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipios')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreign('parroquia_id')
                ->references('id')
                ->on('parroquias')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->unique(['nombre', 'parroquia_id']);
        });

        Schema::table('oficiales', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales', 'centro_votacion_id')) {
                $table->unsignedInteger('centro_votacion_id')->nullable()->after('parroquia_id');

                $table->foreign('centro_votacion_id')
                    ->references('id')
                    ->on('centros_votacion')
                    ->nullOnDelete()
                    ->restrictOnUpdate();
            }
        });

        if (Schema::hasColumn('oficiales', 'centro_votacion') && Schema::hasColumn('oficiales', 'parroquia_id')) {
            $rows = DB::table('oficiales')
                ->whereNotNull('centro_votacion')
                ->where('centro_votacion', '!=', '')
                ->whereNotNull('parroquia_id')
                ->get(['id', 'centro_votacion', 'parroquia_id']);

            foreach ($rows as $row) {
                $parroquia = DB::table('parroquias')->where('id', $row->parroquia_id)->first();
                if (! $parroquia) {
                    continue;
                }

                $centroId = DB::table('centros_votacion')->where([
                    'nombre' => trim((string) $row->centro_votacion),
                    'parroquia_id' => $row->parroquia_id,
                ])->value('id');

                if (! $centroId) {
                    $centroId = DB::table('centros_votacion')->insertGetId([
                        'nombre' => trim((string) $row->centro_votacion),
                        'municipio_id' => $parroquia->municipio_id,
                        'parroquia_id' => $row->parroquia_id,
                    ]);
                }

                DB::table('oficiales')->where('id', $row->id)->update([
                    'centro_votacion_id' => $centroId,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('oficiales', 'centro_votacion_id')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $table->dropForeign(['centro_votacion_id']);
                $table->dropColumn('centro_votacion_id');
            });
        }

        Schema::dropIfExists('centros_votacion');
    }
};
