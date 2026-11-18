<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenRequest;
use App\Models\Orden;
use App\Models\Equipo;
use App\Enums\EstadoOrden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdenController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = $request->string('q')->trim()->toString();
        $consulta = Orden::query()->with('equipo');
        if ($busqueda !== '') {
            $patron = '%'.$busqueda.'%';
            $consulta->where('falla_reportada', 'like', $patron)
                ->orWhere('diagnostico', 'like', $patron)
                ->orWhere('estado', 'like', $patron)
                ->orWhereHas('equipo', fn ($padre) => $padre->where('numero_serie', 'like', $patron));
        }
        $registros = $consulta->latest('id')->paginate(12)->withQueryString();

        return view('ordenes.index', compact('registros', 'busqueda'));
    }

    public function create(): View
    {
        return view('ordenes.form', ['registro' => new Orden(), 'opciones' => Equipo::orderBy('numero_serie')->get()]);
    }

    public function store(OrdenRequest $request): RedirectResponse
    {
        $registro = Orden::create($request->validated());

        return redirect()->route('ordenes.show', $registro)->with('success', 'Registro creado.');
    }

    public function show(Orden $orden): View
    {
        return view('ordenes.show', ['registro' => $orden]);
    }

    public function edit(Orden $orden): View
    {
        return view('ordenes.form', ['registro' => $orden, 'opciones' => Equipo::orderBy('numero_serie')->get()]);
    }

    public function update(OrdenRequest $request, Orden $orden): RedirectResponse
    {
        $orden->update($request->validated());

        return redirect()->route('ordenes.show', $orden)->with('success', 'Cambios guardados.');
    }

    public function destroy(Orden $orden): RedirectResponse
    {
        $orden->delete();

        return redirect()->route('ordenes.index')->with('success', 'Registro eliminado.');
    }
}
