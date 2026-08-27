<?php

namespace Database\Seeders;

use App\Models\Discapacidade;
use Illuminate\Database\Seeder;

class DiscapacidadesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Visual',
            'Auditiva',
            'Motora',
            'Intelectual',
            'Psicosocial',
            'Múltiple',
            'Lenguaje / Comunicación',
        ];

        foreach ($items as $nombre) {
            Discapacidade::updateOrCreate(
                ['nombre' => $nombre],
                ['nombre' => $nombre]
            );
        }
    }
}
