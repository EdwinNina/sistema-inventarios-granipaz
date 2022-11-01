<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'paterno' => $this->faker->lastName(),
            'materno' => $this->faker->lastName(),
            'tipo_documento' => $this->faker->randomElement(['NIT', 'CI', 'PASAPORTE', 'RUA']),
            'nro_documento' => $this->faker->randomNumber(5),
            'empresa' => $this->faker->company(),
            'email' => $this->faker->email(),
            'celular' => $this->faker->randomNumber(7),
            'tipo_persona' =>  $this->faker->randomElement(['PROVEEDOR', 'CLIENTE']),
        ];
    }
}
