@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')
<form class="card p-4 mx-auto shadow-sm" style="max-width: 28rem" method="post" action="{{ route('login.store') }}">
    @csrf
    <h1 class="h3 mb-4">Iniciar sesión</h1>
    <label for="email" class="form-label">Correo electrónico</label>
    <input class="form-control mb-3" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
    <label for="password" class="form-label">Contraseña</label>
    <input class="form-control mb-4" id="password" type="password" name="password" autocomplete="current-password" required>
    <button class="btn btn-primary">Ingresar</button>
</form>
@endsection
