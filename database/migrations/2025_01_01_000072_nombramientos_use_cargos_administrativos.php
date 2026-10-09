<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales_nombramientos') || ! Schema::hasTable('cargos_administrativos')) {
            return;
        }

        // Remapear id_tipo_nombramiento: de catalogo_nombramientos → cargos_administrativos (mismo nombre).
        if (Schema::hasTable('catalogo_nombramientos')) {
            $catalogo = DB::table('catalogo_nombramientos')->get(['id', 'nombre']);
            $map = [];

            foreach ($catalogo as $item) {
                $nombre = trim((string) $item->nombre);
                if ($nombre === '') {
                    continue;
                }

                $existing = DB::table('cargos_administrativos')
                    ->whereRaw('LOWER(TRIM(nombre_cargo)) = ?', [mb_strtolower($nombre)])
                    ->value('id');

                if (! $existing) {
                    $existing = DB::table('cargos_administrativos')->insertGetId([
                        'nombre_cargo' => $nombre,
                    ]);
                }

                $map[(int) $item->id] = (int) $existing;
            }

            foreach ($map as $oldId => $newId) {
                if ($oldId === $newId) {
                    continue;
                }
                DB::table('oficiales_nombramientos')
                    ->where('id_tipo_nombramiento', $oldId)
                    ->update(['id_tipo_nombramiento' => $newId]);
            }
        }

        $this->dropForeignKeyIfExists('oficiales_nombramientos', 'id_tipo_nombramiento');

        Schema::table('oficiales_nombramientos', function (Blueprint $table) {
            $table->foreign('id_tipo_nombramiento')
                ->references('id')
                ->on('cargos_administrativos')
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales_nombramientos')) {
            return;
        }

        $this->dropForeignKeyIfExists('oficiales_nombramientos', 'id_tipo_nombramiento');

        if (Schema::hasTable('catalogo_nombramientos')) {
            Schema::table('oficiales_nombramientos', function (Blueprint $table) {
                $table->foreign('id_tipo_nombramiento')
                    ->references('id')
                    ->on('catalogo_nombramientos')
                    ->restrictOnDelete()
                    ->restrictOnUpdate();
            });
        }
    }

    private function dropForeignKeyIfExists(string $table, string $column): void
    {
        $database = DB::getDatabaseName();
        $constraints = DB::select(
            'SELECT CONSTRAINT_NAME
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = ?
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?
               AND REFERENCED_TABLE_NAME IS NOT NULL',
            [$database, $table, $column]
        );

        foreach ($constraints as $row) {
            $name = $row->CONSTRAINT_NAME ?? null;
            if (! $name) {
                continue;
            }
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$name}`");
        }
    }
};
