<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = ['cliente_id', 'tipo', 'marca', 'modelo', 'numero_serie'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class);
    }
}
