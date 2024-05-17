<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            'roles_id' => '1',
            'name' => 'admin',
            'email' => 'superadmin@correo.com',
            'password' => \Hash::make('123456'),
        ]);
    }
}
