<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('tipos_clientes')->insert([
            ['id' => 1, 'codigo' => 11, 'tipo' => 'Registro civil'],
            ['id' => 2, 'codigo' => 12, 'tipo' => 'Tarjeta de identidad'],
            ['id' => 3, 'codigo' => 13, 'tipo' => 'Cédula de ciudadanía'],
            ['id' => 4, 'codigo' => 21, 'tipo' => 'Tarjeta de extranjería'],
            ['id' => 5, 'codigo' => 22, 'tipo' => 'Cédula de extranjería'],
            ['id' => 6, 'codigo' => 31, 'tipo' => 'NIT '],
            ['id' => 7, 'codigo' => 41, 'tipo' => 'Pasaporte'],
            ['id' => 8, 'codigo' => 42, 'tipo' => 'Documento de identificación extranjero'],
            ['id' => 9, 'codigo' => 47, 'tipo' => 'PEP'],
            ['id' => 10, 'codigo' => 50, 'tipo' => 'Nit de otro país'],
            ['id' => 11, 'codigo' => 91, 'tipo' => 'NIUP'],
        ]);
    }
}