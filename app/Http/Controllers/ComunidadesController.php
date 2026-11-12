<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Catálogo de barrios y comunidades (solo administrador). */
class ComunidadesController extends Controller
{
    public function index(Request $request)
    {
        $q = mb_substr(trim((string) $request->query('q', '')), 0, 60);
        $comunidades = Comunidad::activas()->ordenadas()
            ->when($q !== '', fn ($c) => $c->where('nombre', 'like', "%$q%"))
            ->get();

        return view('comunidades.index', compact('comunidades', 'q'));
    }

    public function create()
    {
        return view('comunidades.form', ['comunidad' => new Comunidad(['tipo' => 'Barrio'])]);
    }

    public function store(Request $request)
    {
        Comunidad::create($this->validar($request));
        return redirect()->route('comunidades.index')->with('success', 'Comunidad agregada.');
    }

    public function edit(int $id)
    {
        return view('comunidades.form', ['comunidad' => Comunidad::activas()->findOrFail($id)]);
    }

    public function update(Request $request, int $id)
    {
        Comunidad::activas()->findOrFail($id)->update($this->validar($request, $id));
        return redirect()->route('comunidades.index')->with('success', 'Comunidad actualizada.');
    }

    /** Dar de baja: deja de aparecer en el portal, pero los reportes antiguos la conservan. */
    public function baja(int $id)
    {
        $c = Comunidad::activas()->findOrFail($id);
        $c->baja = now();
        $c->save();
        return redirect()->route('comunidades.index')->with('success', "Se dio de baja \"{$c->nombre}\".");
    }

    private function validar(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:120',
                Rule::unique('comunidades', 'nombre')->whereNull('baja')->ignore($id)],
            'tipo'   => ['required', Rule::in(Comunidad::TIPOS)],
        ], [
            'nombre.required' => 'Escriba el nombre.',
            'nombre.min'      => 'El nombre es muy corto.',
            'nombre.max'      => 'El nombre admite hasta 120 caracteres.',
            'nombre.unique'   => 'Ya existe una comunidad con ese nombre.',
            'tipo.required'   => 'Elija el tipo.',
            'tipo.in'         => 'Elija un tipo de la lista.',
        ]);
    }
}
