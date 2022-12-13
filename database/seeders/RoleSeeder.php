<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'nombre' => 'administrador',
            'descripcion' => 'Administrador del sistema',
            'estado' => 1
        ]);

        Role::create([
            'nombre' => 'encargado',
            'descripcion' => 'Encargado de gestionar ventas de productos en el sistema',
            'estado' => 1
        ]);
    }
}
