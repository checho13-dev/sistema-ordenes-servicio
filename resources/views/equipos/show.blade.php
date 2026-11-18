@extends('layouts.app')
@section('title', 'Detalle | Equipos')
@section('content')
<a href="{{ route('equipos.index') }}">Volver a Equipos</a>
<h1 class="my-4">Detalle de equipo #{{ $registro->id }}</h1>
<div class="record card p-4 shadow-sm">
<dl class="row">
    <dt class="col-sm-4">Cliente</dt><dd class="col-sm-8">{{ $registro->cliente->nombre }}</dd>
    <dt class="col-sm-4">Tipo</dt><dd class="col-sm-8">{{ $registro->tipo }}</dd>
    <dt class="col-sm-4">Marca</dt><dd class="col-sm-8">{{ $registro->marca }}</dd>
    <dt class="col-sm-4">Modelo</dt><dd class="col-sm-8">{{ $registro->modelo }}</dd>
    <dt class="col-sm-4">Número de serie</dt><dd class="col-sm-8">{{ $registro->numero_serie }}</dd>
</dl>
@include('shared.actions', ['ruta' => 'equipos'])
</div>
@endsection
