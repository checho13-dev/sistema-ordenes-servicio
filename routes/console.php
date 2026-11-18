<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

Artisan::command('operador:crear', function () {
    $data = [
        'name' => $this->ask('Nombre del operador'),
        'email' => $this->ask('Correo electrónico'),
        'password' => $this->secret('Contraseña (mínimo 12 caracteres)'),
    ];
    $validator = Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:12', 'max:72'],
    ]);
    if ($validator->fails()) {
        $this->error('Revisa el nombre, el correo (debe ser único) y la longitud de la contraseña.');
        return 1;
    }

    User::create($validator->validated());
    $this->info('Operador creado.');
    return 0;
})->purpose('Crea un operador mediante entrada interactiva');
