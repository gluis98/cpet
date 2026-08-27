<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cargo_administrativo_id')->nullable();
            $table->unsignedBigInteger('tipo_cargo_id')->nullable();
            $table->enum('tipo_funcionario', ['Policial', 'Administrativo', 'Obrero'])->default('Policial');
            $table->string('documento_identidad', 50)->nullable()->unique();
            $table->string('nombre_completo')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('tipo_sangre', 3)->nullable();
            $table->string('talla_camisa')->nullable();
            $table->string('talla_pantalon', 10)->nullable();
            $table->string('talla_zapatos')->nullable();
            $table->string('talla_saco')->nullable();
            $table->string('talla_kepin_toka')->nullable();
            $table->string('talla_tacon')->nullable();
            $table->string('talla_falda')->nullable();
            $table->string('talla_gorra')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('estado_civil', 50)->nullable();
            $table->text('direccion')->nullable();
            $table->string('tipo_vivienda', 30)->nullable();
            $table->text('direccion_vivienda')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('telefono_residencial', 50)->nullable();
            $table->string('correo_electronico', 100)->nullable();
            $table->enum('estatus', [
                'Operativo',
                'No Operativo',
                'Retirado',
                'Suspendido',
                'Jubilado',
                'Fallecido',
            ])->nullable()->default('Operativo');
            $table->string('numero_placa')->nullable();
            $table->unsignedSmallInteger('parroquia_id')->nullable();
            $table->text('fotografia')->nullable();
            $table->text('centro_votacion')->nullable();
            $table->text('direccion_centro')->nullable();

            $table->foreign('parroquia_id')
                ->references('id')
                ->on('parroquias')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreign('cargo_administrativo_id')
                ->references('id')
                ->on('cargos_administrativos')
                ->nullOnDelete();

            $table->foreign('tipo_cargo_id')
                ->references('id')
                ->on('tipos_cargos')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales');
    }
};
