<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BandejaController;
use App\Http\Controllers\ComunidadesController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portal público (sin login, con límite de peticiones por IP)
|--------------------------------------------------------------------------
*/
Route::middleware('throttle:portal')->group(function () {
    Route::get('/', [PortalController::class, 'inicio'])->name('portal.inicio');
    Route::post('reportar', [PortalController::class, 'enviar'])->middleware('throttle:portal-envio')->name('portal.enviar');
    Route::get('reporte-enviado', [PortalController::class, 'listo'])->name('portal.listo');
    Route::post('consultar', [PortalController::class, 'consultar'])->middleware('throttle:portal-consulta')->name('portal.consultar');
});

/*
|--------------------------------------------------------------------------
| Inicio de sesión del personal
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'formulario'])->name('login');
    Route::post('login', [LoginController::class, 'ingresar'])->middleware('throttle:portal-consulta');
});
Route::post('logout', [LoginController::class, 'salir'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Panel del personal (requiere sesión)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('home', fn () => redirect()->route('bandeja.index'))->name('home');

    // Bandeja: Recibido → En proceso → Resuelto.
    Route::get('bandeja', [BandejaController::class, 'index'])->name('bandeja.index');
    Route::get('bandeja/{id}', [BandejaController::class, 'show'])->whereNumber('id')->name('bandeja.show');
    Route::post('bandeja/{id}/estado', [BandejaController::class, 'estado'])->whereNumber('id')->name('bandeja.estado');
    Route::get('bandeja/{id}/foto/{foto}', [BandejaController::class, 'foto'])->whereNumber(['id', 'foto'])->name('bandeja.foto');

    // Catálogos: solo el administrador.
    Route::middleware('can:admin')->group(function () {
        Route::resource('comunidades', ComunidadesController::class)
            ->parameters(['comunidades' => 'id'])->except(['show', 'destroy']);
        Route::post('comunidades/{id}/baja', [ComunidadesController::class, 'baja'])->whereNumber('id')->name('comunidades.baja');

        Route::resource('usuarios', UsuariosController::class)
            ->parameters(['usuarios' => 'id'])->except(['show', 'destroy']);
        Route::post('usuarios/{id}/baja', [UsuariosController::class, 'baja'])->whereNumber('id')->name('usuarios.baja');
    });
});
