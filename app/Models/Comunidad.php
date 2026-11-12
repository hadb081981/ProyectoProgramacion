<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** Barrio, colonia, aldea o caserío donde ocurre el problema. */
class Comunidad extends Model
{
    protected $table = 'comunidades';

    protected $fillable = ['nombre', 'tipo'];

    protected $casts = ['baja' => 'datetime'];

    public const TIPOS = ['Cabecera', 'Barrio', 'Colonia', 'Aldea', 'Caserío', 'Finca'];

    /** Solo las activas (sin fecha de baja). */
    public function scopeActivas(Builder $q): Builder
    {
        return $q->whereNull('baja');
    }

    /** Ordenadas por tipo (Cabecera, Barrio, …) y luego por nombre. */
    public function scopeOrdenadas(Builder $q): Builder
    {
        $casos = collect(self::TIPOS)->map(fn ($t, $i) => "WHEN ? THEN $i")->implode(' ');
        return $q->orderByRaw("CASE tipo $casos ELSE 99 END", self::TIPOS)->orderBy('nombre');
    }
}
