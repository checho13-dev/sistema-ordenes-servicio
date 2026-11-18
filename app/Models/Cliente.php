<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = ['nombre', 'documento', 'telefono', 'correo', 'direccion'];

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }
}
