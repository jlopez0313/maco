<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImpuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('impuestos')->insert([
            ['id' =>1, 'codigo' =>'01', 'concepto' => 'IVA Exento', 'tarifa' => '0.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>2, 'codigo' =>'01', 'concepto' => 'IVA Bienes/Servicios al 5', 'tarifa' => '5.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>3, 'codigo' =>'01', 'concepto' => 'IVA Contratos firmados con el estado antes de ley 1819', 'tarifa' => '16.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>4, 'codigo' =>'01', 'concepto' => 'IVA Tarifa general', 'tarifa' => '19.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>5, 'codigo' =>'01', 'concepto' => 'IVA Excluido', 'tarifa' => '0', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>6, 'codigo' =>'04', 'concepto' => 'INC Tarifa especial', 'tarifa' => '2.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>7, 'codigo' =>'04', 'concepto' => 'INC Tarifa especial', 'tarifa' => '4.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>8, 'codigo' =>'04', 'concepto' => 'INC Tarifa general', 'tarifa' => '8.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>9, 'codigo' =>'04', 'concepto' => 'INC Tarifa especial', 'tarifa' => '16.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
            ['id' =>10, 'codigo' =>'ZZ', 'concepto' => 'No Aplica', 'tarifa' => '0.00', 'tipo_tarifa' => 'P', 'tipo_impuesto' => 'I'],
        ]);
    }
}