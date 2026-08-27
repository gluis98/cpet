<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tipos_cargos') || ! Schema::hasTable('cargos_administrativos')) {
            return;
        }

        // 1) Mover nombres de tipos_cargos → cargos_administrativos
        $tipos = DB::table('tipos_cargos')->orderBy('id')->get();
        $map = []; // tipo_cargo_id => cargo_administrativo_id

        foreach ($tipos as $tipo) {
            $nombre = trim((string) $tipo->nombre);
            if ($nombre === '') {
                continue;
            }

            $existing = DB::table('cargos_administrativos')
                ->where('nombre_cargo', $nombre)
                ->first();

            if ($existing) {
                $map[(int) $tipo->id] = (int) $existing->id;
                continue;
            }

            $newId = DB::table('cargos_administrativos')->insertGetId([
                'nombre_cargo' => $nombre,
            ]);
            $map[(int) $tipo->id] = (int) $newId;
        }

        // 2) Reasignar oficiales.tipo_cargo_id → cargo_administrativo_id (si aún no tiene)
        if (Schema::hasColumn('oficiales', 'tipo_cargo_id')) {
            $oficiales = DB::table('oficiales')
                ->whereNotNull('tipo_cargo_id')
                ->get(['id', 'tipo_cargo_id', 'cargo_administrativo_id']);

            foreach ($oficiales as $oficial) {
                $tipoId = (int) $oficial->tipo_cargo_id;
                if (! isset($map[$tipoId])) {
                    continue;
                }

                // Solo rellenar si no tiene cargo administrativo asignado
                if (empty($oficial->cargo_administrativo_id)) {
                    DB::table('oficiales')
                        ->where('id', $oficial->id)
                        ->update(['cargo_administrativo_id' => $map[$tipoId]]);
                }
            }

            Schema::table('oficiales', function (Blueprint $table) {
                $table->dropForeign(['tipo_cargo_id']);
                $table->dropColumn('tipo_cargo_id');
            });
        }

        Schema::dropIfExists('tipos_cargos');
    }

    public function down(): void
    {
        if (! Schema::hasTable('tipos_cargos')) {
            Schema::create('tipos_cargos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre')->unique();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('oficiales') && ! Schema::hasColumn('oficiales', 'tipo_cargo_id')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $table->unsignedBigInteger('tipo_cargo_id')->nullable()->after('cargo_administrativo_id');
                $table->foreign('tipo_cargo_id')
                    ->references('id')
                    ->on('tipos_cargos')
                    ->nullOnDelete();
            });
        }
    }
};
