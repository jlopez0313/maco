<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('departamentos')->insert([
            ['id' =>1, 'codigo' =>'91', 'departamento' => 'Amazonas'],
            ['id' =>2, 'codigo' =>'05', 'departamento' => 'Antioquia'],
            ['id' =>3, 'codigo' =>'81', 'departamento' => 'Arauca'],
            ['id' =>4, 'codigo' =>'08', 'departamento' => 'Atlántico'],
            ['id' =>5, 'codigo' =>'11', 'departamento' => 'Bogotá'],
            ['id' =>6, 'codigo' =>'13', 'departamento' => 'Bolívar'],
            ['id' =>7, 'codigo' =>'15', 'departamento' => 'Boyacá'],
            ['id' =>8, 'codigo' =>'17', 'departamento' => 'Caldas'],
            ['id' =>9, 'codigo' =>'18', 'departamento' => 'Caquetá'],
            ['id' =>10, 'codigo' =>'85', 'departamento' => 'Casanare'],
            ['id' =>11, 'codigo' =>'19', 'departamento' => 'Cauca'],
            ['id' =>12, 'codigo' =>'20', 'departamento' => 'Cesar'],
            ['id' =>13, 'codigo' =>'27', 'departamento' => 'Chocó'],
            ['id' =>14, 'codigo' =>'23', 'departamento' => 'Córdoba'],
            ['id' =>15, 'codigo' =>'25', 'departamento' => 'Cundinamarca'],
            ['id' =>16, 'codigo' =>'94', 'departamento' => 'Guainía'],
            ['id' =>17, 'codigo' =>'95', 'departamento' => 'Guaviare'],
            ['id' =>18, 'codigo' =>'41', 'departamento' => 'Huila'],
            ['id' =>19, 'codigo' =>'44', 'departamento' => 'La Guajira'],
            ['id' =>20, 'codigo' =>'47', 'departamento' => 'Magdalena'],
            ['id' =>21, 'codigo' =>'50', 'departamento' => 'Meta'],
            ['id' =>22, 'codigo' =>'52', 'departamento' => 'Nariño'],
            ['id' =>23, 'codigo' =>'54', 'departamento' => 'Norte de Santander'],
            ['id' =>24, 'codigo' =>'86', 'departamento' => 'Putumayo'],
            ['id' =>25, 'codigo' =>'63', 'departamento' => 'Quindío'],
            ['id' =>26, 'codigo' =>'66', 'departamento' => 'Risaralda'],
            ['id' =>27, 'codigo' =>'88', 'departamento' => 'San Andrés y Providencia'],
            ['id' =>28, 'codigo' =>'68', 'departamento' => 'Santander'],
            ['id' =>29, 'codigo' =>'70', 'departamento' => 'Sucre'],
            ['id' =>30, 'codigo' =>'73', 'departamento' => 'Tolima'],
            ['id' =>31, 'codigo' =>'76', 'departamento' => 'Valle del Cauca'],
            ['id' =>32, 'codigo' =>'97', 'departamento' => 'Vaupés'],
            ['id' =>33, 'codigo' =>'99', 'departamento' => 'Vichada'],
        ]);
    }
}
