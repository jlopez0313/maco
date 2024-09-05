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
        ]);
    }
}