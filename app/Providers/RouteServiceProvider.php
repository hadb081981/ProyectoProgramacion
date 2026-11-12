<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /** Después de iniciar sesión, el personal entra a la bandeja. */
    public const HOME = '/bandeja';

    public function boot(): void
    {
        $this->configurarLimites();

        $this->routes(function () {
            Route::middleware('web')->group(base_path('routes/web.php'));
        });
    }

    /** Límites por IP de las páginas públicas (no requieren sesión). */
    protected function configurarLimites(): void
    {
        // Navegación general del portal.
        RateLimiter::for('portal', fn (Request $r) => Limit::perMinute(120)->by($r->ip()));

        // Envío de reportes: 10 cada 10 minutos y 30 por día (incluye intentos con error).
        RateLimiter::for('portal-envio', fn (Request $r) => [
            Limit::perMinutes(10, 10)->by('envio10:' . $r->ip()),
            Limit::perDay(30)->by('envioDia:' . $r->ip()),
        ]);

        // Consulta por folio + teléfono, e intentos de inicio de sesión.
        RateLimiter::for('portal-consulta', fn (Request $r) => Limit::perMinute(10)->by($r->ip()));
    }
}
