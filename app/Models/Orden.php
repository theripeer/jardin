<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'direccion',
        'fitosanitario',
        'servicio_id',
        'plazos',
        'cuadrilla_id',
        'image1',
        'image2',
        'estados',
        'estpago',
        'observacion'
    ];

    public function servicio(): BelongsTo
    {
        return $this->BelongsTo(Servicio::class);
    }

    public function cuadrilla(): BelongsTo
    {
        return $this->BelongsTo(Cuadrilla::class);
    }







}
