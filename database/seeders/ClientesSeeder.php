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
            'documento' => 123456789,
            'dv' => 1,
            'nombre' => 'varios null varios',
            'matricula' => '784112',
            'comercio' => 'varios null varios',
            'direccion' => 'Calle 123',
            'celular' => '1234567890',
            'tipo_doc_id' => 6,
            'responsabilidad_fiscal_id' => 5,
        ]);
    }
}
