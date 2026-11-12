<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Historial del reporte: cada cambio de estado con su comentario para el vecino. */
class ReporteComentario extends Model
{
    protected $table = 'reporte_comentarios';

    public const UPDATED_AT = null;

    protected $fillable = ['idreporte', 'idusuario', 'estado_anterior', 'estado_nuevo', 'comentario'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idusuario');
    }
}
