<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponsabilidadesFiscalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('responsabilidades_fiscales')->insert([
            ['id' => 1, 'codigo' => 'O-13', 'descripcion' => 'Gran contribuyente'],
            ['id' => 2, 'codigo' => 'O-15', 'descripcion' => 'Autorretenedor'],
            ['id' => 3, 'codigo' => 'O-23', 'descripcion' => 'Agente de retención en el impuesto sobre las ventas'],
            ['id' => 4, 'codigo' => 'O-47', 'descripcion' => 'Régimen Simple de Tributación – SIMPLE '],
            ['id' => 5, 'codigo' => 'R-99-PN', 'descripcion' => 'No responsable PN'],
        ]);
    }
}