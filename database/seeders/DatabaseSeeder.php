<?php

namespace Database\Seeders;

use App\Enums\EstadoOrden;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Orden;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            if (Cliente::query()->exists()) {
                return;
            }

            foreach (EstadoOrden::cases() as $estado) {
                $cliente = Cliente::factory()->create();
                $equipo = Equipo::factory()->for($cliente)->create();
                Orden::factory()->for($equipo)->create(['estado' => $estado]);
            }
        });
    }
}
