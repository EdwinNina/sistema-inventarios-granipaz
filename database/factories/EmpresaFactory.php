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
            'empresa' => 'Granipaz',
            'direccion' => 'Barrio Los Milagros Av. Cuarto Anillo',
            'nit' => '123456',
            'correo' => 'granipaz@gmail.com',
            'celular' => '60566656',
            'paterno' => 'Carvajal',
            'materno' => 'Machicado',
            'nombre' => 'Grover Rene',
            'logotipo' => 'empresa/' . $this->faker->image('public/storage/empresa', 500, 500, null, false),
            'stock_minimo' => 10,
        ];
    }
}
