<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Storage::deleteDirectory('public/productos');
        Storage::makeDirectory('public/productos');
        Storage::deleteDirectory('public/empresa');
        Storage::makeDirectory('public/empresa');

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        // Categoria::factory(20)->create();
        // SubCategoria::factory(40)->create();
        // Producto::factory(50)->create();
        // Persona::factory(60)->create();
        Empresa::factory(1)->create();
    }
}
