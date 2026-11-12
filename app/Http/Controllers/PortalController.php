<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comunidad;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Portal público (sin login): el vecino reporta un problema con una foto y su barrio o
 * comunidad, recibe un folio y después consulta el estado con folio + teléfono.
 *
 * Seguridad: rutas con límite de envíos por IP, campo trampa contra robots,
 * foto JPG/PNG de máx. 10 MB guardada con nombre generado en un disco privado.
 */
class PortalController extends Controller
{
    public function inicio()
    {
        return view('portal.inicio', [
            'categorias'  => Categoria::activas()->get(),
            'comunidades' => Comunidad::activas()->ordenadas()->get(['id', 'nombre', 'tipo']),
        ]);
    }

    public function enviar(Request $request)
    {
        if ($request->filled('sitio_web')) { // campo trampa: solo los robots lo llenan
            return redirect()->route('portal.inicio');
        }

        $request->merge([
            'nombre'   => Reporte::normalizarNombre($request->input('nombre')),
            'telefono' => Reporte::limpiarTelefono($request->input('telefono')),
        ]);

        $v = $request->validate([
            'idcategoria' => ['required', 'integer', Rule::exists('categorias', 'id')->where('activo', true)],
            'descripcion' => 'required|string|min:10|max:1000',
            'idcomunidad' => ['required', 'integer', Rule::exists('comunidades', 'id')->whereNull('baja')],
            'referencia'  => 'nullable|string|max:255',
            'nombre'      => 'required|string|min:3|max:120',
            'telefono'    => ['required', 'regex:/^\d{8}$/'],
            'foto'        => 'nullable|file|mimes:' . Reporte::MIMES . '|max:' . Reporte::MAX_KB,
        ], [
            'idcategoria.required' => 'Elija qué tipo de problema quiere reportar.',
            'idcategoria.*'        => 'Elija una categoría de la lista.',
            'descripcion.required' => 'Describa el problema.',
            'descripcion.min'      => 'Describa el problema con al menos 10 caracteres.',
            'descripcion.max'      => 'La descripción admite hasta 1000 caracteres.',
            'idcomunidad.required' => 'Elija su barrio o comunidad.',
            'idcomunidad.*'        => 'Elija un barrio o comunidad de la lista.',
            'referencia.max'       => 'La referencia admite hasta 255 caracteres.',
            'nombre.required'      => 'Escriba su nombre.',
            'nombre.min'           => 'Escriba su nombre completo.',
            'nombre.max'           => 'El nombre admite hasta 120 letras.',
            'telefono.required'    => 'Escriba su número de teléfono.',
            'telefono.regex'       => 'El teléfono debe tener 8 dígitos.',
            'foto.mimes'           => 'La foto debe ser JPG o PNG.',
            'foto.max'             => 'La foto puede pesar hasta 10 MB.',
            'foto.file'            => 'No se pudo recibir la foto. Intente de nuevo.',
        ]);

        $reporte = null;
        try {
            $reporte = DB::transaction(function () use ($v, $request) {
                $r = Reporte::create([
                    'idcategoria' => $v['idcategoria'],
                    'idarea'      => Categoria::whereKey($v['idcategoria'])->value('idarea'), // el área que atiende esa categoría
                    'idcomunidad' => $v['idcomunidad'],
                    'nombre'      => $v['nombre'],
                    'telefono'    => $v['telefono'],
                    'descripcion' => trim($v['descripcion']),
                    'referencia'  => trim((string) ($v['referencia'] ?? '')) ?: null,
                    'estado'      => 'recibido',
                    'ip'          => $request->ip(),
                ]);
                $r->registrar(null, 'recibido', null);
                if ($request->hasFile('foto')) {
                    $r->guardarFoto($request->file('foto'));
                }
                return $r;
            });
        } catch (\Throwable $e) {
            if ($reporte) {
                Storage::disk('reportes')->deleteDirectory((string) $reporte->id); // no dejar fotos huérfanas
            }
            report($e);
            return back()->withInput($request->except('foto'))
                ->withErrors(['envio' => 'No pudimos guardar su reporte. Intente de nuevo en unos minutos.']);
        }

        // El folio viaja en la sesión: la pantalla de "enviado" no se puede abrir con un id en la URL.
        return redirect()->route('portal.listo')->with('folio', $reporte->folio);
    }

    public function listo()
    {
        $folio = session('folio');
        return $folio ? view('portal.listo', ['folio' => $folio]) : redirect()->route('portal.inicio');
    }

    /** Consulta del estado con folio + teléfono (los dos deben coincidir). */
    public function consultar(Request $request)
    {
        $request->validate(['folio' => 'required|string|max:30', 'tel_consulta' => 'required|string|max:20'], [
            'folio.required'        => 'Escriba el folio de su reporte.',
            'tel_consulta.required' => 'Escriba el teléfono con el que reportó.',
        ]);

        $id = Reporte::idDeFolio($request->input('folio'));
        $reporte = $id ? Reporte::with(['categoria', 'comunidad'])
            ->where('id', $id)
            ->where('telefono', Reporte::limpiarTelefono($request->input('tel_consulta')))
            ->first() : null;

        if (!$reporte) {
            return redirect()->to(route('portal.inicio') . '#consultar')->withInput($request->only('folio'))
                ->withErrors(['consulta' => 'No encontramos un reporte con ese folio y teléfono. Revise los datos.']);
        }

        // Al vecino solo se le muestran los comentarios que escribió el personal.
        $comentarios = $reporte->comentarios()->whereNotNull('comentario')->get();

        return view('portal.consulta', compact('reporte', 'comentarios'));
    }
}
