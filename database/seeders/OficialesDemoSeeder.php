<?php

namespace Database\Seeders;

use App\Models\Oficiale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OficialesDemoSeeder extends Seeder
{
    public function run(): void
    {
        $oficiales = [
            [
                'documento_identidad' => '12345678',
                'nombre_completo' => 'Carlos Andrés Méndez Ríos',
                'fecha_nacimiento' => '1988-03-15',
                'tipo_sangre' => 'O+',
                'fecha_ingreso' => '2012-06-01',
                'estado_civil' => 'Casado',
                'direccion' => 'Av. Bolívar, sector La Beatriz, Valera',
                'telefono' => '0414-5550101',
                'telefono_residencial' => '0271-2520101',
                'correo_electronico' => 'cmendez@cpet.demo',
                'estatus' => 'Operativo',
                'numero_placa' => 'PET-001',
                'talla_camisa' => '42',
                'talla_pantalon' => '34',
                'talla_zapatos' => '42',
                'centro_votacion' => 'Escuela Bolivariana La Beatriz',
            ],
            [
                'documento_identidad' => '13456789',
                'nombre_completo' => 'María Fernanda Pérez Salazar',
                'fecha_nacimiento' => '1990-07-22',
                'tipo_sangre' => 'A+',
                'fecha_ingreso' => '2015-01-10',
                'estado_civil' => 'Soltero',
                'direccion' => 'Calle 5, La Puerta, Valera',
                'telefono' => '0424-5550102',
                'correo_electronico' => 'mperez@cpet.demo',
                'estatus' => 'Operativo',
                'numero_placa' => 'PET-002',
                'talla_camisa' => '38',
                'talla_pantalon' => '30',
                'talla_zapatos' => '38',
                'centro_votacion' => 'Liceo La Puerta',
            ],
            [
                'documento_identidad' => '14567890',
                'nombre_completo' => 'José Luis Herrera Campos',
                'fecha_nacimiento' => '1985-11-08',
                'tipo_sangre' => 'B+',
                'fecha_ingreso' => '2010-09-20',
                'estado_civil' => 'Casado',
                'direccion' => 'Urbanización El Morro, Trujillo',
                'telefono' => '0416-5550103',
                'telefono_residencial' => '0271-2520103',
                'correo_electronico' => 'jherrera@cpet.demo',
                'estatus' => 'Operativo',
                'numero_placa' => 'PET-003',
                'talla_camisa' => '44',
                'talla_pantalon' => '36',
                'talla_zapatos' => '43',
            ],
            [
                'documento_identidad' => '15678901',
                'nombre_completo' => 'Ana Victoria Ruiz Mora',
                'fecha_nacimiento' => '1992-01-30',
                'tipo_sangre' => 'AB+',
                'fecha_ingreso' => '2018-04-05',
                'estado_civil' => 'Unión libre',
                'direccion' => 'Sector San Luis, Boconó',
                'telefono' => '0412-5550104',
                'correo_electronico' => 'aruiz@cpet.demo',
                'estatus' => 'No Operativo',
                'numero_placa' => 'PET-004',
                'talla_camisa' => '36',
                'talla_pantalon' => '28',
                'talla_zapatos' => '37',
            ],
            [
                'documento_identidad' => '16789012',
                'nombre_completo' => 'Luis Alberto Gómez Peña',
                'fecha_nacimiento' => '1987-09-12',
                'tipo_sangre' => 'O-',
                'fecha_ingreso' => '2011-08-15',
                'estado_civil' => 'Casado',
                'direccion' => 'Av. Universidad, Valera',
                'telefono' => '0414-5550105',
                'correo_electronico' => 'lgomez@cpet.demo',
                'estatus' => 'Suspendido',
                'numero_placa' => 'PET-005',
                'talla_camisa' => '40',
                'talla_pantalon' => '32',
                'talla_zapatos' => '41',
            ],
            [
                'documento_identidad' => '17890123',
                'nombre_completo' => 'Pedro Emilio Suárez Linares',
                'fecha_nacimiento' => '1978-05-25',
                'tipo_sangre' => 'A-',
                'fecha_ingreso' => '2000-03-01',
                'estado_civil' => 'Casado',
                'direccion' => 'Carretera Trujillo–Valera, km 4',
                'telefono' => '0426-5550106',
                'correo_electronico' => 'psuarez@cpet.demo',
                'estatus' => 'Retirado',
                'numero_placa' => 'PET-006',
                'talla_camisa' => '46',
                'talla_pantalon' => '38',
                'talla_zapatos' => '44',
            ],
            [
                'documento_identidad' => '18901234',
                'nombre_completo' => 'Rosa Elena Delgado Briceño',
                'fecha_nacimiento' => '1965-12-03',
                'tipo_sangre' => 'B-',
                'fecha_ingreso' => '1992-07-20',
                'estado_civil' => 'Viudo',
                'direccion' => 'Centro de Trujillo',
                'telefono' => '0414-5550107',
                'correo_electronico' => 'rdelgado@cpet.demo',
                'estatus' => 'Jubilado',
                'numero_placa' => 'PET-007',
                'talla_camisa' => '38',
                'talla_pantalon' => '30',
                'talla_zapatos' => '38',
            ],
            [
                'documento_identidad' => '19012345',
                'nombre_completo' => 'Diego Armando Castillo Vera',
                'fecha_nacimiento' => '1994-06-18',
                'tipo_sangre' => 'O+',
                'fecha_ingreso' => '2019-02-11',
                'estado_civil' => 'Soltero',
                'direccion' => 'La Concordia, Valera',
                'telefono' => '0412-5550108',
                'correo_electronico' => 'dcastillo@cpet.demo',
                'estatus' => 'Operativo',
                'numero_placa' => 'PET-008',
                'talla_camisa' => '40',
                'talla_pantalon' => '32',
                'talla_zapatos' => '41',
            ],
            [
                'documento_identidad' => '20123456',
                'nombre_completo' => 'Gabriela Isabel Morales Ortiz',
                'fecha_nacimiento' => '1991-04-09',
                'tipo_sangre' => 'A+',
                'fecha_ingreso' => '2016-11-30',
                'estado_civil' => 'Casado',
                'direccion' => 'Sector El Batatal, Valera',
                'telefono' => '0424-5550109',
                'correo_electronico' => 'gmorales@cpet.demo',
                'estatus' => 'No Operativo',
                'numero_placa' => 'PET-009',
                'talla_camisa' => '36',
                'talla_pantalon' => '28',
                'talla_zapatos' => '37',
            ],
            [
                'documento_identidad' => '21234567',
                'nombre_completo' => 'Ricardo José Briceño Leal',
                'fecha_nacimiento' => '1989-08-27',
                'tipo_sangre' => 'B+',
                'fecha_ingreso' => '2014-05-14',
                'estado_civil' => 'Casado',
                'direccion' => 'La Plazuela, Boconó',
                'telefono' => '0416-5550110',
                'correo_electronico' => 'rbriceno@cpet.demo',
                'estatus' => 'Suspendido',
                'numero_placa' => 'PET-010',
                'talla_camisa' => '42',
                'talla_pantalon' => '34',
                'talla_zapatos' => '42',
            ],
        ];

        $jerarquias = [
            '12345678' => 1,  // Oficial
            '13456789' => 7,  // Comisario
            '14567890' => 13, // Agente
            '15678901' => 17, // Cabo Primero
            '16789012' => 21, // Sargento Primero
            '17890123' => 3,  // Oficial Jefe
            '18901234' => 9,  // Comisario Jefe
            '19012345' => 13,
            '20123456' => 17,
            '21234567' => 21,
        ];

        foreach ($oficiales as $row) {
            $row['tipo_funcionario'] = 'Policial';

            Oficiale::updateOrCreate(
                ['documento_identidad' => $row['documento_identidad']],
                $row
            );
        }

        foreach ($jerarquias as $cedula => $cargoId) {
            $oficial = Oficiale::where('documento_identidad', $cedula)->first();
            if (! $oficial) {
                continue;
            }

            DB::table('oficiales_cargos')->updateOrInsert(
                [
                    'id_policia' => $oficial->id,
                    'is_actual' => 1,
                ],
                [
                    'id_cargo' => $cargoId,
                    'fecha_inicio' => $oficial->fecha_ingreso?->format('Y-m-d') ?? now()->format('Y-m-d'),
                    'fecha_fin' => null,
                    'is_actual' => 1,
                ]
            );
        }
    }
}
