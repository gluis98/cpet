<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('oficiales')) {
            DB::statement("ALTER TABLE oficiales MODIFY estatus ENUM(
                'Operativo',
                'No Operativo',
                'En Reposo',
                'Retirado',
                'Suspendido',
                'Jubilado',
                'Fallecido',
                'URRA',
                'Reingreso'
            ) NULL DEFAULT 'Operativo'");

            if (! Schema::hasColumn('oficiales', 'tipo_retiro')) {
                Schema::table('oficiales', function (Blueprint $table) {
                    $table->enum('tipo_retiro', ['Renuncia', 'Destitución'])->nullable()->after('estatus');
                });
            }
        }

        if (! Schema::hasTable('oficiales_reingresos')) {
            Schema::create('oficiales_reingresos', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_policia');
                $table->date('fecha_reingreso');
                $table->text('observaciones')->nullable();

                $table->foreign('id_policia')
                    ->references('id')
                    ->on('oficiales')
                    ->cascadeOnDelete()
                    ->restrictOnUpdate();

                $table->unique(['id_policia', 'fecha_reingreso']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_reingresos');

        if (! Schema::hasTable('oficiales')) {
            return;
        }

        if (Schema::hasColumn('oficiales', 'tipo_retiro')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $table->dropColumn('tipo_retiro');
            });
        }

        DB::table('oficiales')->where('estatus', 'Reingreso')->update(['estatus' => 'Operativo']);

        DB::statement("ALTER TABLE oficiales MODIFY estatus ENUM(
            'Operativo',
            'No Operativo',
            'En Reposo',
            'Retirado',
            'Suspendido',
            'Jubilado',
            'Fallecido',
            'URRA'
        ) NULL DEFAULT 'Operativo'");
    }
};
