@extends('layouts.app')
@section('title', 'Equipos')
@section('content')
<a href="{{ route('equipos.index') }}">Volver a Equipos</a>
<h1 class="mt-3 mb-4">{{ $registro->exists ? 'Editar' : 'Registrar' }} equipo</h1>
<form class="record card p-4 shadow-sm" method="post" action="{{ $registro->exists ? route('equipos.update', $registro) : route('equipos.store') }}">
    @csrf
    @if($registro->exists) @method('PUT') @endif
    <div class="mb-3">
        <label class="form-label" for="cliente_id">Cliente</label>
        <select class="form-select" id="cliente_id" name="cliente_id" required>
            <option value="">Selecciona una opción</option>
            @foreach($opciones as $opcion)
                <option value="{{ $opcion->id }}" @selected((string) old('cliente_id', $registro->cliente_id) === (string) $opcion->id)>{{ $opcion->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="tipo">Tipo</label>
        <input class="form-control" type="text" id="tipo" name="tipo" required value="{{ old('tipo', $registro->tipo) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="marca">Marca</label>
        <input class="form-control" type="text" id="marca" name="marca" required value="{{ old('marca', $registro->marca) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="modelo">Modelo</label>
        <input class="form-control" type="text" id="modelo" name="modelo" required value="{{ old('modelo', $registro->modelo) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="numero_serie">Número de serie</label>
        <input class="form-control" type="text" id="numero_serie" name="numero_serie" required value="{{ old('numero_serie', $registro->numero_serie) }}">
    </div>
    <button class="btn btn-primary align-self-start">Guardar</button>
</form>
@endsection
