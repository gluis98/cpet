<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            'Oficial',
            'Primer Oficial',
            'Oficial Jefe',
            'Inspector',
            'Primer Inspector',
            'Inspector Jefe',
            'Comisario',
            'Primer Comisario',
            'Comisario Jefe',
            'Comisario General',
            'Comisario Mayor',
            'Comisario Superior',
            'Agente',
            'Distinguido',
            'Oficial Agregado',
            'Supervisor Agregado',
            'Cabo Primero',
            'Cabo Segundo',
            'Comisionado',
            'Comisionado Agregado',
            'Sargento Primero',
            'Sargento Segundo',
            'Subinspector',
            'Supervisor',
            'Supervisor Jefe',
        ];

        foreach ($cargos as $index => $nombre) {
            DB::table('cargos')->updateOrInsert(
                ['id' => $index + 1],
                ['nombre_cargo' => $nombre]
            );
        }
    }
}
