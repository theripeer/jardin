<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory; //, softDeletes;

    protected $fillable = [
        'nombre', 'slug', 'r_social','rut', 'is_visible', 'descripcion'
    ];

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }

}
