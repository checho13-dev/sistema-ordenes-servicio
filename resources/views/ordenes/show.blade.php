@extends('layouts.app')
@section('title', 'Detalle | Órdenes de servicio')
@section('content')
<a href="{{ route('ordenes.index') }}">Volver a Órdenes de servicio</a>
<h1 class="my-4">Detalle de orden #{{ $registro->id }}</h1>
<div class="record card p-4 shadow-sm">
<dl class="row">
    <dt class="col-sm-4">Equipo</dt><dd class="col-sm-8">{{ $registro->equipo->numero_serie }}</dd>
    <dt class="col-sm-4">Falla reportada</dt><dd class="col-sm-8">{{ $registro->falla_reportada }}</dd>
    <dt class="col-sm-4">Diagnóstico</dt><dd class="col-sm-8">{{ $registro->diagnostico ?? 'Pendiente' }}</dd>
    <dt class="col-sm-4">Costo estimado (COP)</dt><dd class="col-sm-8">{{ $registro->costo_estimado ?? 'Pendiente' }}</dd>
    <dt class="col-sm-4">Fecha de ingreso</dt><dd class="col-sm-8">{{ $registro->fecha_ingreso }}</dd>
    <dt class="col-sm-4">Fecha de entrega</dt><dd class="col-sm-8">{{ $registro->fecha_entrega ?? 'Pendiente' }}</dd>
    <dt class="col-sm-4">Estado</dt><dd class="col-sm-8">{{ $registro->estado->value }}</dd>
</dl>
@include('shared.actions', ['ruta' => 'ordenes'])
</div>
@endsection
