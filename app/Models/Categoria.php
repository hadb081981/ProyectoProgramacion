<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** Tipo de problema que el vecino puede reportar. */
class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre', 'descripcion', 'icono', 'idarea', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function scopeActivas(Builder $q): Builder
    {
        return $q->where('activo', true)->orderBy('id');
    }
}
