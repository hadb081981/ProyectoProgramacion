<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Área de la municipalidad que atiende ciertas categorías de reportes. */
class Area extends Model
{
    protected $table = 'areas';

    protected $fillable = ['nombre'];
}
