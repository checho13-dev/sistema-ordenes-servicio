<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Orden;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GestionTest extends TestCase
{
    use RefreshDatabase;

    public static function modulos(): array
    {
        return [
            'clientes' => ['clientes', Cliente::class, 'nombre', 'Cliente de prueba'],
            'equipos' => ['equipos', Equipo::class, 'marca', 'Marca del taller'],
            'órdenes' => ['ordenes', Orden::class, 'falla_reportada', 'Falla intermitente'],
        ];
    }

    #[DataProvider('modulos')]
    public function test_ciclo_completo_de_un_registro(string $ruta, string $modelo, string $campo, string $valor): void
    {
        $this->actingAs(User::factory()->create());
        $datos = $modelo::factory()->raw();
        $this->get(route("$ruta.create"))->assertOk();
        $this->post(route("$ruta.store"), $datos)->assertSessionHasNoErrors()->assertRedirect();
        $registro = $modelo::query()->sole();
        $this->get(route("$ruta.show", $registro))->assertOk();
        $this->get(route("$ruta.edit", $registro))->assertOk();

        $datos[$campo] = $valor;
        $this->put(route("$ruta.update", $registro), $datos)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame($valor, $registro->fresh()->getAttribute($campo));
        $this->get(route("$ruta.index", ['q' => $valor]))->assertOk()->assertViewHas('registros',
            fn ($pagina) => $pagina->total() === 1 && $pagina->first()->is($registro));
        $this->get(route("$ruta.index", ['q' => 'xyz_no_existe']))->assertSee('No se encontraron registros');
        $this->delete(route("$ruta.destroy", $registro))->assertRedirect(route("$ruta.index"));
        $this->assertModelMissing($registro);
    }

    public function test_los_tres_modulos_requieren_sesion_para_leer_y_escribir(): void
    {
        foreach (['clientes', 'equipos', 'ordenes'] as $ruta) {
            foreach (['index', 'create'] as $accion) {
                $this->get(route("$ruta.$accion"))->assertRedirect(route('login'));
            }
            $this->post(route("$ruta.store"))->assertRedirect(route('login'));
            $this->get(route("$ruta.show", 1))->assertRedirect(route('login'));
            $this->get(route("$ruta.edit", 1))->assertRedirect(route('login'));
            $this->put(route("$ruta.update", 1))->assertRedirect(route('login'));
            $this->delete(route("$ruta.destroy", 1))->assertRedirect(route('login'));
        }
    }

    public function test_explica_el_motivo_si_hay_registros_dependientes(): void
    {
        $this->actingAs(User::factory()->create());
        $orden = Orden::factory()->create();
        $equipo = $orden->equipo;
        $cliente = $equipo->cliente;
        $this->delete(route('clientes.destroy', $cliente))->assertSessionHas('error', fn ($s) => str_contains($s, 'equipos'));
        $this->delete(route('equipos.destroy', $equipo))->assertSessionHas('error', fn ($s) => str_contains($s, 'órdenes') || str_contains($s, 'ordenes'));
        $this->assertModelExists($cliente);
        $this->assertModelExists($equipo);
    }

    public function test_rechaza_estado_desconocido_y_entrega_anterior_al_ingreso(): void
    {
        $this->actingAs(User::factory()->create());
        $datos = Orden::factory()->raw(['estado' => 'otro', 'fecha_ingreso' => '2026-05-01', 'fecha_entrega' => '2026-04-01']);
        $this->post(route('ordenes.store'), $datos)->assertSessionHasErrors(['estado','fecha_entrega']);
        $this->assertDatabaseCount('ordenes', 0);
    }

    public function test_los_listados_conservan_la_busqueda_al_paginar(): void
    {
        $this->actingAs(User::factory()->create());
        Cliente::factory(13)->create(['nombre' => 'Persona ficticia']);
        $this->get(route('clientes.index', ['q' => 'Persona', 'page' => 2]))
            ->assertOk()->assertViewHas('registros', fn ($pagina) => $pagina->total() === 13 && $pagina->count() === 1
                && str_contains($pagina->url(1), 'q=Persona'));
    }

    public function test_login_y_logout(): void
    {
        $clave = fake()->password(16, 20);
        $usuario = User::factory()->create(['password' => $clave]);
        $this->post(route('login.store'), ['email' => $usuario->email, 'password' => 'incorrecta'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->post(route('login.store'), ['email' => $usuario->email, 'password' => $clave])->assertRedirect('/ordenes');
        $this->assertAuthenticatedAs($usuario);
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
