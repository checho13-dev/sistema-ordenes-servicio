<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipoRequest;
use App\Models\Equipo;
use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipoController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = $request->string('q')->trim()->toString();
        $consulta = Equipo::query()->with('cliente');
        if ($busqueda !== '') {
            $patron = '%'.$busqueda.'%';
            $consulta->where('tipo', 'like', $patron)
                ->orWhere('marca', 'like', $patron)
                ->orWhere('modelo', 'like', $patron)
                ->orWhere('numero_serie', 'like', $patron)
                ->orWhereHas('cliente', fn ($padre) => $padre->where('nombre', 'like', $patron));
        }
        $registros = $consulta->latest('id')->paginate(12)->withQueryString();

        return view('equipos.index', compact('registros', 'busqueda'));
    }

    public function create(): View
    {
        return view('equipos.form', ['registro' => new Equipo(), 'opciones' => Cliente::orderBy('nombre')->get()]);
    }

    public function store(EquipoRequest $request): RedirectResponse
    {
        $registro = Equipo::create($request->validated());

        return redirect()->route('equipos.show', $registro)->with('success', 'Registro creado.');
    }

    public function show(Equipo $equipo): View
    {
        return view('equipos.show', ['registro' => $equipo]);
    }

    public function edit(Equipo $equipo): View
    {
        return view('equipos.form', ['registro' => $equipo, 'opciones' => Cliente::orderBy('nombre')->get()]);
    }

    public function update(EquipoRequest $request, Equipo $equipo): RedirectResponse
    {
        $equipo->update($request->validated());

        return redirect()->route('equipos.show', $equipo)->with('success', 'Cambios guardados.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        try {
            $equipo->delete();
        } catch (QueryException $exception) {
            if (!in_array($exception->errorInfo[0] ?? null, ['23000', '23503'], true)) {
                throw $exception;
            }

            return back()->with('error', 'No se puede eliminar el registro porque tiene ordenes asociados.');
        }

        return redirect()->route('equipos.index')->with('success', 'Registro eliminado.');
    }
}
