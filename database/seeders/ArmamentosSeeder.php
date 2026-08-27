<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArmamentosSeeder extends Seeder
{
    public function run(): void
    {
        $armamentos = [
            ['nombre' => 'Glock 17', 'tipo' => 'Pistola', 'calibre' => '9 mm', 'origen' => 'Austria', 'uso' => 'Policial', 'serial' => null],
            ['nombre' => 'AK-103', 'tipo' => 'Fusil', 'calibre' => '7.62 mm', 'origen' => 'Rusia', 'uso' => 'Militar', 'serial' => null],
            ['nombre' => 'Beretta Px4 Storm', 'tipo' => 'Pistola', 'calibre' => '9 mm', 'origen' => 'Italia', 'uso' => 'Policial', 'serial' => null],
            ['nombre' => 'FN Minimi', 'tipo' => 'Ametralladora', 'calibre' => '5.56 mm', 'origen' => 'Bélgica', 'uso' => 'Militar', 'serial' => null],
            ['nombre' => 'Mossberg 590', 'tipo' => 'Escopeta', 'calibre' => '12 ga', 'origen' => 'Estados Unidos', 'uso' => 'Policial', 'serial' => null],
        ];

        foreach ($armamentos as $index => $arma) {
            DB::table('armamentos')->updateOrInsert(
                ['id' => $index + 1],
                $arma
            );
        }
    }
}
