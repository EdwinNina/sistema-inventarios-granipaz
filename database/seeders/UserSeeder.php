<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'grover carvajal',
            'email' => 'grover_rcm@outlook.com',
            'password' => bcrypt('grover123-G'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Administrador',
            'email' => 'adminSystem@granipaz.com',
            'password' => bcrypt('adminSystem'),
            'role_id' => 1
        ]);
    }
}
