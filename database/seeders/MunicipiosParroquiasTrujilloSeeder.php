<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosParroquiasTrujilloSeeder extends Seeder
{
    /**
     * Municipios y parroquias del estado Trujillo (20 municipios / 93 parroquias).
     *
     * Fuente: división político-territorial vigente (INE / Anexo Wikipedia).
     */
    public function run(): void
    {
        $estadoId = Municipio::ESTADO_TRUJILLO_ID;

        DB::table('estados')->updateOrInsert(
            ['id' => $estadoId],
            ['descripcion' => 'EDO. TRUJILLO']
        );

        $data = [
            'Andrés Bello' => [
                'Santa Isabel',
                'Araguaney',
                'El Jagüito',
                'La Esperanza',
            ],
            'Boconó' => [
                'Boconó',
                'Ayacucho',
                'Burbusay',
                'El Carmen',
                'General Ribas',
                'Guaramacal',
                'Monseñor Jáuregui',
                'Mosquey',
                'Rafael Rangel',
                'San José',
                'San Miguel',
                'Vega de Guaramacal',
            ],
            'Bolívar' => [
                'Sabana Grande',
                'Cheregüé',
                'Granados',
            ],
            'Candelaria' => [
                'Chejendé',
                'Arnoldo Gabaldón',
                'Bolivia',
                'Carrillo',
                'Cegarra',
                'Manuel Salvador Ulloa',
                'San José',
            ],
            'Carache' => [
                'Carache',
                'Cuicas',
                'La Concepción',
                'Panamericana',
                'Santa Cruz',
            ],
            'Escuque' => [
                'Escuque',
                'La Unión',
                'Sabana Libre',
                'Santa Rita',
            ],
            'José Felipe Márquez Cañizales' => [
                'El Socorro',
                'Antonio José de Sucre',
                'Los Caprichos',
            ],
            'Juan Vicente Campo Elías' => [
                'Campo Elías',
                'Arnoldo Gabaldón',
            ],
            'La Ceiba' => [
                'Santa Apolonia',
                'El Progreso',
                'La Ceiba',
                'Tres de Febrero',
            ],
            'Miranda' => [
                'El Dividive',
                'Agua Caliente',
                'Agua Santa',
                'El Cenizo',
                'Valerita',
            ],
            'Monte Carmelo' => [
                'Monte Carmelo',
                'Buena Vista',
                'Santa María del Horcón',
            ],
            'Motatán' => [
                'Motatán',
                'El Baño',
                'Jalisco',
            ],
            'Pampán' => [
                'Pampán',
                'Flor de Patria',
                'La Paz',
                'Santa Ana',
            ],
            'Pampanito' => [
                'Pampanito',
                'La Concepción',
                'Pampanito II',
            ],
            'Rafael Rangel' => [
                'Betijoque',
                'José Gregorio Hernández',
                'La Pueblita',
                'Los Cedros',
            ],
            'San Rafael de Carvajal' => [
                'Carvajal',
                'Antonio Nicolás Briceño',
                'Campo Alegre',
                'José Leonardo Suárez',
            ],
            'Sucre' => [
                'Sabana de Mendoza',
                'El Paraíso',
                'Junín',
                'Valmore Rodríguez',
            ],
            'Trujillo' => [
                'Matriz',
                'Andrés Linares',
                'Chiquinquirá',
                'Cristóbal Mendoza',
                'Cruz Carrillo',
                'Monseñor Carrillo',
                'Tres Esquinas',
            ],
            'Urdaneta' => [
                'La Quebrada',
                'Cabimbú',
                'Jajó',
                'La Mesa',
                'Santiago',
                'Tuñame',
            ],
            'Valera' => [
                'Mercedes Díaz',
                'Juan Ignacio Montilla',
                'La Beatriz',
                'La Puerta',
                'Mendoza del Valle de Momboy',
                'San Luis',
            ],
        ];

        foreach ($data as $municipioNombre => $parroquias) {
            $municipioId = DB::table('municipios')->where([
                'descripcion' => $municipioNombre,
                'estado_id' => $estadoId,
            ])->value('id');

            if (! $municipioId) {
                $municipioId = DB::table('municipios')->insertGetId([
                    'descripcion' => $municipioNombre,
                    'estado_id' => $estadoId,
                ]);
            }

            foreach ($parroquias as $parroquiaNombre) {
                $exists = DB::table('parroquias')->where([
                    'descripcion' => $parroquiaNombre,
                    'municipio_id' => $municipioId,
                ])->exists();

                if ($exists) {
                    continue;
                }

                DB::table('parroquias')->insert([
                    'descripcion' => $parroquiaNombre,
                    'municipio_id' => $municipioId,
                    'atencionfamilias' => 0,
                ]);
            }
        }
    }
}
