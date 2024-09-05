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
        $this->call(DepartamentosSeeder::class);
        $this->call(CiudadesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UserTenantSeeder::class);
        $this->call(ResponsabilidadesFiscalesSeeder::class);
        $this->call(TiposClientesSeeder::class);
        $this->call(TiposDocumentosSeeder::class);
        $this->call(ClientesSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
