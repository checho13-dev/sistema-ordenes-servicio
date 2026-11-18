@extends('layouts.app')
@section('title', 'Órdenes de servicio')
@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <h1>Órdenes de servicio</h1><a class="btn btn-primary" href="{{ route('ordenes.create') }}">Registrar orden</a>
</div>
<form method="get" class="d-flex gap-2 mb-4" role="search">
    <input class="form-control" aria-label="Buscar en Órdenes de servicio" name="q" value="{{ $busqueda }}" placeholder="Buscar en Órdenes de servicio">
    <button class="btn btn-outline-dark">Buscar</button>
    @if($busqueda !== '')<a class="btn btn-light" href="{{ route('ordenes.index') }}">Limpiar</a>@endif
</form>
<div class="card table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead><tr><th scope="col">Equipo</th><th scope="col">Fecha de ingreso</th><th scope="col">Estado</th><th scope="col">Detalle</th></tr></thead>
    <tbody>
    @forelse($registros as $registro)
        <tr><td>{{ $registro->equipo->numero_serie }}</td><td>{{ $registro->fecha_ingreso }}</td><td>{{ $registro->estado->value }}</td><td><a href="{{ route('ordenes.show', $registro) }}">Ver #{{ $registro->id }}</a></td></tr>
    @empty
        <tr><td colspan="4" class="p-4">No se encontraron registros.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $registros->links() }}</div>
@endsection
