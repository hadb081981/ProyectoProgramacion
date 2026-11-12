<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Usuario del panel. tipo_usuario: 1 = administrador, 0 = encargado de un área.
 */
class User extends Authenticatable
{
    public const ADMIN = 1;
    public const ENCARGADO = 0;

    protected $fillable = ['name', 'email', 'password', 'tipo_usuario', 'idarea'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed', 'baja' => 'datetime', 'tipo_usuario' => 'integer'];
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'idarea');
    }

    public function esAdmin(): bool
    {
        return $this->tipo_usuario === self::ADMIN;
    }
}
