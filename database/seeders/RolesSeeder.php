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
                'slug' => 'SUDO',
                'rol' => 'superadmin'
            ],
            [
                'slug' => 'ADMIN',
                'rol' => 'admin'
            ],
            [
                'slug' => 'SELL',
                'rol' => 'Comercial'
            ],
        ]);
    }
}
