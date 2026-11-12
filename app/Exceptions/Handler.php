<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    public function register(): void
    {
        // Token CSRF vencido (la página estuvo abierta mucho tiempo): en lugar de la pantalla
        // "419 Page expired", vuelve al formulario con un aviso y con lo que ya se había escrito.
        $this->renderable(function (Throwable $e, $request) {
            $vencido = $e instanceof TokenMismatchException
                || ($e instanceof HttpExceptionInterface && $e->getStatusCode() === 419);
            if (!$vencido || !$request->is('reportar', 'consultar', 'login')) {
                return null;
            }

            $aviso = 'La página estuvo abierta mucho tiempo. Por seguridad, revise los datos y vuelva a enviarlos.';
            if ($request->is('login')) {
                return redirect()->route('login')->withInput($request->only('email'))->withErrors(['email' => $aviso]);
            }
            $consulta = $request->is('consultar');
            return redirect()->to(route('portal.inicio') . ($consulta ? '#consultar' : ''))
                ->withInput($request->except(['_token', 'foto', 'tel_consulta']))
                ->withErrors([$consulta ? 'consulta' : 'envio' => $aviso]);
        });
    }
}
