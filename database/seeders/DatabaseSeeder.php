<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            EstadosSeeder::class,
            CargosSeeder::class,
            ArmamentosSeeder::class,
            CargosAdministrativosSeeder::class,
            DiscapacidadesSeeder::class,
            OficialesDemoSeeder::class,
        ]);
    }
}
