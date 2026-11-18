<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:6,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::resource('clientes', ClienteController::class)->parameters(['clientes' => 'cliente']);
    Route::resource('equipos', EquipoController::class)->parameters(['equipos' => 'equipo']);
    Route::resource('ordenes', OrdenController::class)->parameters(['ordenes' => 'orden']);
    Route::redirect('/', '/ordenes');
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
});
