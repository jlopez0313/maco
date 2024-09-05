<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('clientes')->insert([
            'id' => 1,
            'updated_by' => 1,
            'tipo_id' => 1,
            'ciudad_id' => 150,
            'documento' => 1,
            'dv' => 8,
            'nombre' => 'Generico',
            'matricula' => '111111',
            'comercio' => 'Generico',
            'direccion' => 'Generico',
            'celular' => '1234567890',
            'tipo_doc_id' => 1,
            'responsabilidad_fiscal_id' => 1,
        ]);
    }
}
