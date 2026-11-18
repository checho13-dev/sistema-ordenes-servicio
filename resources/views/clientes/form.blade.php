@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<a href="{{ route('clientes.index') }}">Volver a Clientes</a>
<h1 class="mt-3 mb-4">{{ $registro->exists ? 'Editar' : 'Registrar' }} cliente</h1>
<form class="record card p-4 shadow-sm" method="post" action="{{ $registro->exists ? route('clientes.update', $registro) : route('clientes.store') }}">
    @csrf
    @if($registro->exists) @method('PUT') @endif
    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre</label>
        <input class="form-control" type="text" id="nombre" name="nombre" required value="{{ old('nombre', $registro->nombre) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="documento">Documento</label>
        <input class="form-control" type="text" id="documento" name="documento" required value="{{ old('documento', $registro->documento) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="telefono">Teléfono</label>
        <input class="form-control" type="tel" id="telefono" name="telefono" required value="{{ old('telefono', $registro->telefono) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="correo">Correo</label>
        <input class="form-control" type="email" id="correo" name="correo" required value="{{ old('correo', $registro->correo) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="direccion">Dirección</label>
        <input class="form-control" type="text" id="direccion" name="direccion" required value="{{ old('direccion', $registro->direccion) }}">
    </div>
    <button class="btn btn-primary align-self-start">Guardar</button>
</form>
@endsection
