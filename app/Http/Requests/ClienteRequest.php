<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:255', Rule::unique('clientes', 'documento')->ignore($this->route('cliente'))],
            'telefono' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'max:255', 'email'],
            'direccion' => ['required', 'string', 'max:255'],
        ];
    }
}
