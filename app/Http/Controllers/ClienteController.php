<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = $request->string('q')->trim()->toString();
        $consulta = Cliente::query();
        if ($busqueda !== '') {
            $patron = '%'.$busqueda.'%';
            $consulta->where('nombre', 'like', $patron)
                ->orWhere('documento', 'like', $patron)
                ->orWhere('correo', 'like', $patron);
        }
        $registros = $consulta->latest('id')->paginate(12)->withQueryString();

        return view('clientes.index', compact('registros', 'busqueda'));
    }

    public function create(): View
    {
        return view('clientes.form', ['registro' => new Cliente()]);
    }

    public function store(ClienteRequest $request): RedirectResponse
    {
        $registro = Cliente::create($request->validated());

        return redirect()->route('clientes.show', $registro)->with('success', 'Registro creado.');
    }

    public function show(Cliente $cliente): View
    {
        return view('clientes.show', ['registro' => $cliente]);
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.form', ['registro' => $cliente]);
    }

    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $cliente->update($request->validated());

        return redirect()->route('clientes.show', $cliente)->with('success', 'Cambios guardados.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        try {
            $cliente->delete();
        } catch (QueryException $exception) {
            if (!in_array($exception->errorInfo[0] ?? null, ['23000', '23503'], true)) {
                throw $exception;
            }

            return back()->with('error', 'No se puede eliminar el registro porque tiene equipos asociados.');
        }

        return redirect()->route('clientes.index')->with('success', 'Registro eliminado.');
    }
}
