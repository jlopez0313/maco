<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('roles')->insert([
            [
                'id' => 1,
                'slug' => 'SUDO',
                'rol' => 'superadmin'
            ],
            [
                'id' => 2,
                'slug' => 'ADMIN',
                'rol' => 'admin'
            ],
            [
                'id' => 3,
                'slug' => 'SELL',
                'rol' => 'Comercial'
            ],
        ]);
    }
}
