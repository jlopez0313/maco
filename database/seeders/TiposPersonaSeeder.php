<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('tipos_personas')->insert([
            ['id' => 1, 'codigo' => 1, 'tipo' => 'Persona Jurídica y asimiladas'],
            ['id' => 2, 'codigo' => 2, 'tipo' => 'Persona Natural y asimiladas'],
        ]);
    }
}