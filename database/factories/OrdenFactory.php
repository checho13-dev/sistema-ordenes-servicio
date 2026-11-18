<?php

namespace Database\Factories;

use App\Models\Equipo;
use App\Enums\EstadoOrden;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'equipo_id' => Equipo::factory(),
            'falla_reportada' => fake()->randomElement(['Se apaga al iniciar', 'La pantalla pierde señal', 'No reconoce el almacenamiento']),
            'diagnostico' => null,
            'costo_estimado' => null,
            'fecha_ingreso' => today()->toDateString(),
            'fecha_entrega' => null,
            'estado' => EstadoOrden::Recibido->value,
        ];
    }
}
