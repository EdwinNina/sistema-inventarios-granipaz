<?php

namespace Database\Factories;

use App\Models\SubCategoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->text('50'),
            'descripcion' => $this->faker->text('150'),
            'imagen' => 'productos/' . $this->faker->image('public/storage/productos', 500, 500, null, false),
            'stock' => $this->faker->numberBetween(1, 50),
            'precio_unitario' => $this->faker->randomFloat(2, 1, 5),
            'sub_categoria_id' => SubCategoria::get()->random()->id
        ];
    }
}
