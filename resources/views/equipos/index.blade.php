@extends('layouts.app')
@section('title', 'Equipos')
@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <h1>Equipos</h1><a class="btn btn-primary" href="{{ route('equipos.create') }}">Registrar equipo</a>
</div>
<form method="get" class="d-flex gap-2 mb-4" role="search">
    <input class="form-control" aria-label="Buscar en Equipos" name="q" value="{{ $busqueda }}" placeholder="Buscar en Equipos">
    <button class="btn btn-outline-dark">Buscar</button>
    @if($busqueda !== '')<a class="btn btn-light" href="{{ route('equipos.index') }}">Limpiar</a>@endif
</form>
<div class="card table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead><tr><th scope="col">Cliente</th><th scope="col">Marca</th><th scope="col">Número de serie</th><th scope="col">Detalle</th></tr></thead>
    <tbody>
    @forelse($registros as $registro)
        <tr><td>{{ $registro->cliente->nombre }}</td><td>{{ $registro->marca }}</td><td>{{ $registro->numero_serie }}</td><td><a href="{{ route('equipos.show', $registro) }}">Ver #{{ $registro->id }}</a></td></tr>
    @empty
        <tr><td colspan="4" class="p-4">No se encontraron registros.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $registros->links() }}</div>
@endsection
