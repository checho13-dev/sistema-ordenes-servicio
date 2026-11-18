@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <h1>Clientes</h1><a class="btn btn-primary" href="{{ route('clientes.create') }}">Registrar cliente</a>
</div>
<form method="get" class="d-flex gap-2 mb-4" role="search">
    <input class="form-control" aria-label="Buscar en Clientes" name="q" value="{{ $busqueda }}" placeholder="Buscar en Clientes">
    <button class="btn btn-outline-dark">Buscar</button>
    @if($busqueda !== '')<a class="btn btn-light" href="{{ route('clientes.index') }}">Limpiar</a>@endif
</form>
<div class="card table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead><tr><th scope="col">Nombre</th><th scope="col">Documento</th><th scope="col">Teléfono</th><th scope="col">Detalle</th></tr></thead>
    <tbody>
    @forelse($registros as $registro)
        <tr><td>{{ $registro->nombre }}</td><td>{{ $registro->documento }}</td><td>{{ $registro->telefono }}</td><td><a href="{{ route('clientes.show', $registro) }}">Ver #{{ $registro->id }}</a></td></tr>
    @empty
        <tr><td colspan="4" class="p-4">No se encontraron registros.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $registros->links() }}</div>
@endsection
