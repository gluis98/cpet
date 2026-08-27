<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosAdministrativosSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
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

        $cargos = array_values(array_unique($cargos));
        sort($cargos);

        foreach ($cargos as $nombre) {
            DB::table('cargos_administrativos')->updateOrInsert(
                ['nombre_cargo' => $nombre],
                ['nombre_cargo' => $nombre]
            );
        }
    }
}
