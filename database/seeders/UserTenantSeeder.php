<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            'roles_id' => '1',
            'name' => 'administrador',
            'email' => 'usuario@macosystem.com',
            'password' => \Hash::make('macosystem123'),
        ]);
    }
}
