<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/** Usuarios del panel (solo administrador): administradores y encargados de área. */
class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = User::with('area')->whereNull('baja')->orderByDesc('tipo_usuario')->orderBy('name')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.form', ['usuario' => new User(['tipo_usuario' => User::ENCARGADO]), 'areas' => Area::orderBy('nombre')->get()]);
    }

    public function store(Request $request)
    {
        User::create($this->validar($request));
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado.');
    }

    public function edit(int $id)
    {
        return view('usuarios.form', ['usuario' => User::whereNull('baja')->findOrFail($id), 'areas' => Area::orderBy('nombre')->get()]);
    }

    public function update(Request $request, int $id)
    {
        $u = User::whereNull('baja')->findOrFail($id);
        $datos = $this->validar($request, $u);
        if (empty($datos['password'])) {
            unset($datos['password']); // contraseña en blanco = no cambiarla
        }
        $u->update($datos);
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado.');
    }

    /** Dar de baja: ya no puede iniciar sesión, pero su historial se conserva. */
    public function baja(Request $request, int $id)
    {
        $u = User::whereNull('baja')->findOrFail($id);
        if ($u->id === $request->user()->id) {
            return back()->with('error', 'No puede darse de baja a sí mismo.');
        }
        $u->baja = now();
        $u->save();
        return redirect()->route('usuarios.index')->with('success', "Se dio de baja a {$u->name}.");
    }

    private function validar(Request $request, ?User $u = null): array
    {
        $datos = $request->validate([
            'name'         => 'required|string|min:3|max:120',
            'email'        => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($u?->id)],
            'tipo_usuario' => ['required', Rule::in([User::ADMIN, User::ENCARGADO])],
            'idarea'       => ['nullable', 'required_if:tipo_usuario,' . User::ENCARGADO, 'integer', 'exists:areas,id'],
            'password'     => [$u ? 'nullable' : 'required', 'string', 'max:255', Password::min(8)],
        ], [
            'name.required'       => 'Escriba el nombre.',
            'name.min'            => 'Escriba el nombre completo.',
            'name.max'            => 'El nombre admite hasta 120 caracteres.',
            'email.required'      => 'Escriba el correo.',
            'email.email'         => 'Escriba un correo válido.',
            'email.max'           => 'El correo admite hasta 150 caracteres.',
            'email.unique'        => 'Ya existe un usuario con ese correo.',
            'tipo_usuario.*'      => 'Elija el tipo de usuario.',
            'idarea.required_if'  => 'Elija el área que atiende el encargado.',
            'idarea.*'            => 'Elija un área de la lista.',
            'password.required'   => 'Escriba una contraseña.',
            'password.min'        => 'La contraseña debe tener al menos 8 caracteres.',
        ]);
        $datos['tipo_usuario'] = (int) $datos['tipo_usuario'];
        if ($datos['tipo_usuario'] === User::ADMIN) {
            $datos['idarea'] = null; // el administrador ve todas las áreas
        }
        return $datos;
    }
}
