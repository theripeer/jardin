<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servicio extends Model
{
    use HasFactory;
    //protected $guarded = [];
    protected $fillable = [
        'empresa_id',
        'nombre',
        'precio',
        'slug',
        'is_visible'
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
    }






    
}
