<?php

namespace App\Enums;

enum EstadoOrden: string
{
    case Recibido = 'recibido';
    case EnDiagnostico = 'en diagnóstico';
    case EnReparacion = 'en reparación';
    case Listo = 'listo';
    case Entregado = 'entregado';
}
