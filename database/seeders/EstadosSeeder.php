<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            [1, 'DTTO. CAPITAL'],
            [22, 'EDO. AMAZONAS'],
            [2, 'EDO. ANZOATEGUI'],
            [3, 'EDO. APURE'],
            [4, 'EDO. ARAGUA'],
            [5, 'EDO. BARINAS'],
            [6, 'EDO. BOLIVAR'],
            [7, 'EDO. CARABOBO'],
            [8, 'EDO. COJEDES'],
            [23, 'EDO. DELTA AMACURO'],
            [9, 'EDO. FALCON'],
            [10, 'EDO. GUARICO'],
            [11, 'EDO. LARA'],
            [12, 'EDO. MERIDA'],
            [13, 'EDO. MIRANDA'],
            [14, 'EDO. MONAGAS'],
            [15, 'EDO. NVA. ESPARTA'],
            [16, 'EDO. PORTUGUESA'],
            [17, 'EDO. SUCRE'],
            [18, 'EDO. TACHIRA'],
            [19, 'EDO. TRUJILLO'],
            [24, 'EDO. VARGAS'],
            [20, 'EDO. YARACUY'],
            [21, 'EDO. ZULIA'],
        ];

        foreach ($estados as [$id, $descripcion]) {
            DB::table('estados')->updateOrInsert(
                ['id' => $id],
                ['descripcion' => $descripcion]
            );
        }
    }
}
