<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Inicio y cierre de sesión del personal. */
class LoginController extends Controller
{
    public function formulario()
    {
        return view('auth.login');
    }

    public function ingresar(Request $request)
    {
        $datos = $request->validate([
            'email'    => 'required|email|max:150',
            'password' => 'required|string|max:255',
        ], [
            'email.required'    => 'Escriba su correo.',
            'email.email'       => 'Escriba un correo válido.',
            'password.required' => 'Escriba su contraseña.',
        ]);

        // Los usuarios dados de baja no pueden entrar.
        if (Auth::attempt($datos + ['baja' => null], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => 'Correo o contraseña incorrectos.']);
    }

    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal.inicio');
    }
}
