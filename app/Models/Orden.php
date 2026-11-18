<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\EstadoOrden;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = ['equipo_id', 'falla_reportada', 'diagnostico', 'costo_estimado', 'fecha_ingreso', 'fecha_entrega', 'estado'];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    protected function casts(): array
    {
        return ['estado' => EstadoOrden::class, 'costo_estimado' => 'decimal:2'];
    }
}
