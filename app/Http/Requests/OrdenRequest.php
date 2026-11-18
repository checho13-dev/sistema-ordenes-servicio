<?php

namespace App\Http\Requests;

use App\Enums\EstadoOrden;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrdenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'equipo_id' => ['required', 'integer', 'exists:equipos,id'],
            'falla_reportada' => ['required', 'string', 'max:5000'],
            'diagnostico' => ['nullable', 'string', 'max:5000'],
            'costo_estimado' => ['nullable', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999.99'],
            'fecha_ingreso' => ['required', 'date'],
            'fecha_entrega' => ['nullable', 'date', 'after_or_equal:fecha_ingreso'],
            'estado' => ['required', Rule::enum(EstadoOrden::class)],
        ];
    }
}
