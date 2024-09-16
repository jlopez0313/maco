<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(UserTenantSeeder::class);
        
        $this->call(TiposDocumentosSeeder::class); // Tabla 3
        $this->call(MediosPagoSeeder::class); // Tabla 5
        $this->call(ImpuestosSeeder::class); // Tabla 11
        $this->call(UnidadesMedidaSeeder::class); // Tabla 12
        // Tabla 13 - MONEDAS
        $this->call(TiposPersonaSeeder::class); // Tabla 20
        $this->call(FormasPagoSeeder::class); // Tabla 26
        // Tabla 28 - AMBIENTES 
        // Tabla 31 - PRODUCTOS
        $this->call(DepartamentosSeeder::class); // Tabla 34
        $this->call(CiudadesSeeder::class); // Tabla 35
        $this->call(ResponsabilidadesFiscalesSeeder::class); // Tabla 36
        // Tabla 38 - TIPO DE OPERACION
        // Tabla 39 - CODIGOS POSTALES - Codigo de Ciudad

        $this->call(ClientesSeeder::class);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
