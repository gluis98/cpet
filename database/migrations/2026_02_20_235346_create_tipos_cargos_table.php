<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipos_cargos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // Insertar los tipos de cargos iniciales
        $tiposCargos = [
            'AYUDANTE DE SERVICIOS DE COCINA',
            'ASEADOR',
            'OBRERO NO CLASIFICADO',
            'MENSAJERO',
            'AUXILIAR DE SERVICIOS DE OFICINA',
            'DEPOSITARIO',
            'AUXILIAR DE TELECOMUNICACIONES',
            'AYUDANTE DE SERVICIOS GENERALES',
            'BARBERO',
            'MECANICO DE MOTO',
            'ALBAÑIL',
            'JARDINERO',
            'MECANICO AUTOMOTRIZ',
            'PINTOR',
            'PSICOLOGO II',
            'CAPELLAN II',
            'ASISTENTE ADMINISTRATIVO III',
            'ASISTENTE ADMINISTRATIVO IV',
            'MEDICO I',
            'ANALISTA DE PROCESAMIENTO DE DATOS I',
            'ASISTENTE DE ESTADISTICA II',
            'SECRETARIO II',
            'ARCHIVISTA I',
            'SECRETARIO I',
            'ANALISTA DE PERSONAL I',
            'ABOGADO JEFE',
            'ASISTENTE ADMINISTRATIVO V',
            'CONTABILISTA III',
            'ASISTENTE ADMINISTRATIVO I',
        ];

        // Remover duplicados y ordenar
        $tiposCargos = array_unique($tiposCargos);
        sort($tiposCargos);

        foreach ($tiposCargos as $tipo) {
            DB::table('tipos_cargos')->insert([
                'nombre' => $tipo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cargos');
    }
};
