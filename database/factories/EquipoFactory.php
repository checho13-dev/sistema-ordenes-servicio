<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'tipo' => fake()->randomElement(['Portátil', 'Televisor', 'Computador de escritorio']),
            'marca' => fake()->randomElement(['Marca Andina', 'Marca Horizonte']),
            'modelo' => fake()->bothify('Serie ??-###'),
            'numero_serie' => fake()->unique()->bothify('EQ-???-####'),
        ];
    }
}
