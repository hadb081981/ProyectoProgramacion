<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Permiso "admin": gestionar usuarios y comunidades, y ver los reportes de todas las áreas.
        // Los encargados (no admin) solo atienden los reportes de su área.
        Gate::define('admin', fn (User $u) => $u->esAdmin());
    }
}
