@extends('layouts.app')
@section('title', 'Órdenes de servicio')
@section('content')
<a href="{{ route('ordenes.index') }}">Volver a Órdenes de servicio</a>
<h1 class="mt-3 mb-4">{{ $registro->exists ? 'Editar' : 'Registrar' }} orden</h1>
<form class="record card p-4 shadow-sm" method="post" action="{{ $registro->exists ? route('ordenes.update', $registro) : route('ordenes.store') }}">
    @csrf
    @if($registro->exists) @method('PUT') @endif
    <div class="mb-3">
        <label class="form-label" for="equipo_id">Equipo</label>
        <select class="form-select" id="equipo_id" name="equipo_id" required>
            <option value="">Selecciona una opción</option>
            @foreach($opciones as $opcion)
                <option value="{{ $opcion->id }}" @selected((string) old('equipo_id', $registro->equipo_id) === (string) $opcion->id)>{{ $opcion->numero_serie }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="falla_reportada">Falla reportada</label>
        <textarea class="form-control" rows="3" id="falla_reportada" name="falla_reportada" required>{{ old('falla_reportada', $registro->falla_reportada) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label" for="diagnostico">Diagnóstico</label>
        <textarea class="form-control" rows="3" id="diagnostico" name="diagnostico">{{ old('diagnostico', $registro->diagnostico) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label" for="costo_estimado">Costo estimado (COP)</label>
        <input class="form-control" type="number" id="costo_estimado" name="costo_estimado" value="{{ old('costo_estimado', $registro->costo_estimado) }}" step="0.01" min="0">
    </div>
    <div class="mb-3">
        <label class="form-label" for="fecha_ingreso">Fecha de ingreso</label>
        <input class="form-control" type="date" id="fecha_ingreso" name="fecha_ingreso" required value="{{ old('fecha_ingreso', $registro->fecha_ingreso) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="fecha_entrega">Fecha de entrega</label>
        <input class="form-control" type="date" id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega', $registro->fecha_entrega) }}">
    </div>
    <div class="mb-3">
        <label class="form-label" for="estado">Estado</label>
        <select class="form-select" id="estado" name="estado" required>
            <option value="">Selecciona una opción</option>
            @foreach(\App\Enums\EstadoOrden::cases() as $opcion)
                <option value="{{ $opcion->value }}" @selected((string) old('estado', $registro->estado?->value) === (string) $opcion->value)>{{ $opcion->value }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary align-self-start">Guardar</button>
</form>
@endsection
