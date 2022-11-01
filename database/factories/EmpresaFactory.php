<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'empresa' => 'Soalpro Lacteos Lta',
            'direccion' => 'Av. Jaime Mendonza Quinto Anillo #123',
            'nit' => '4567894',
            'correo' => 'soalpro@lacteos.com',
            'celular' => '60614488',
            'paterno' => 'Marca',
            'materno' => 'Luta',
            'nombre' => 'Jaime',
            'logotipo' => 'productos/' . $this->faker->image('public/storage/empresa', 500, 500, null, false),
            'stock_minimo' => 10,
        ];
    }
}
