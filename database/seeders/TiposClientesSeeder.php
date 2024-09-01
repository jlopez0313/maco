<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('tipos_clientes')->insert([
            ['id' => 1, 'codigo' => 1, 'tipo' => 'Persona Jurídica y asimiladas'],
            ['id' => 2, 'codigo' => 2, 'tipo' => 'Persona Natural y asimiladas'],
        ]);
    }
}