@extends('layouts.app')
@section('title', 'Detalle | Clientes')
@section('content')
<a href="{{ route('clientes.index') }}">Volver a Clientes</a>
<h1 class="my-4">Detalle de cliente #{{ $registro->id }}</h1>
<div class="record card p-4 shadow-sm">
<dl class="row">
    <dt class="col-sm-4">Nombre</dt><dd class="col-sm-8">{{ $registro->nombre }}</dd>
    <dt class="col-sm-4">Documento</dt><dd class="col-sm-8">{{ $registro->documento }}</dd>
    <dt class="col-sm-4">Teléfono</dt><dd class="col-sm-8">{{ $registro->telefono }}</dd>
    <dt class="col-sm-4">Correo</dt><dd class="col-sm-8">{{ $registro->correo }}</dd>
    <dt class="col-sm-4">Dirección</dt><dd class="col-sm-8">{{ $registro->direccion }}</dd>
</dl>
@include('shared.actions', ['ruta' => 'clientes'])
</div>
@endsection
