<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormasPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('formas_pagos')->insert([
            ['id' => 1, 'codigo' => 1, 'descripcion' => 'Contado'],
            ['id' => 2, 'codigo' => 2, 'descripcion' => 'Crédito'],
        ]);
    }
}