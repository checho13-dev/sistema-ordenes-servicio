<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'Escribe un correo electrónico válido.',
    'unique' => 'Ya existe un registro con este :attribute.',
    'exists' => 'El registro seleccionado para :attribute ya no existe.',
    'string' => 'El campo :attribute debe contener texto.',
    'max' => ['string' => 'El campo :attribute admite hasta :max caracteres.', 'numeric' => 'El máximo para :attribute es :max.'],
    'min' => ['numeric' => 'El mínimo para :attribute es :min.'],
    'numeric' => 'Escribe un número válido en :attribute.',
    'decimal' => 'El costo admite hasta dos decimales.',
    'date' => 'Escribe una fecha válida en :attribute.',
    'after_or_equal' => 'La entrega debe ser igual o posterior al ingreso.',
    'enum' => 'Selecciona un estado válido.',
    'attributes' => ['cliente_id' => 'cliente', 'equipo_id' => 'equipo', 'numero_serie' => 'número de serie', 'email' => 'correo', 'password' => 'contraseña'],
];
