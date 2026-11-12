<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Bandeja del personal: tablero de 3 columnas (Recibido, En proceso, Resuelto).
 * El administrador ve todos los reportes; el encargado, solo los de su área.
 */
class BandejaController extends Controller
{
    public function index(Request $request)
    {
        $q = mb_substr(trim((string) $request->query('q', '')), 0, 60);

        $consulta = Reporte::visiblesPara($request->user())->with(['categoria', 'comunidad'])->latest('id');
        if ($q !== '') {
            $id = Reporte::idDeFolio($q);
            $consulta->where(function ($w) use ($q, $id) {
                $w->where('nombre', 'like', "%$q%")
                  ->orWhere('telefono', 'like', "%$q%")
                  ->orWhereHas('comunidad', fn ($c) => $c->where('nombre', 'like', "%$q%"));
                if ($id) {
                    $w->orWhere('id', $id);
                }
            });
        }

        // Se agrupan por estado para pintar las 3 columnas del tablero.
        $columnas = $consulta->limit(300)->get()->groupBy('estado');

        return view('bandeja.index', compact('columnas', 'q'));
    }

    public function show(Request $request, int $id)
    {
        $reporte = $this->autorizar($request, $id);
        $reporte->load(['categoria', 'comunidad', 'fotos', 'comentarios.usuario']);

        return view('bandeja.show', compact('reporte'));
    }

    /** Cambia el estado con un comentario obligatorio que el vecino verá al consultar. */
    public function estado(Request $request, int $id)
    {
        $reporte = $this->autorizar($request, $id);
        $v = $request->validate([
            'estado'     => 'required|in:' . implode(',', array_keys(Reporte::ESTADOS)),
            'comentario' => 'required|string|min:5|max:1000',
        ], [
            'estado.required'     => 'Elija el nuevo estado.',
            'estado.in'           => 'Elija un estado de la lista.',
            'comentario.required' => 'Escriba un comentario para el vecino.',
            'comentario.min'      => 'El comentario debe tener al menos 5 caracteres.',
            'comentario.max'      => 'El comentario admite hasta 1000 caracteres.',
        ]);

        DB::transaction(function () use ($reporte, $v, $request) {
            $reporte->registrar($request->user()->id, $v['estado'], $v['comentario']);
            $reporte->estado = $v['estado'];
            $reporte->fecha_cierre = $v['estado'] === 'resuelto' ? now() : null;
            $reporte->save();
        });

        return redirect()->route('bandeja.show', $reporte->id)
            ->with('success', 'Reporte actualizado a "' . Reporte::infoEstado($v['estado'])['txt'] . '". El vecino ya puede ver su comentario.');
    }

    /** Muestra la foto del reporte solo a quien puede ver el reporte (el disco es privado). */
    public function foto(Request $request, int $id, int $foto)
    {
        $reporte = $this->autorizar($request, $id);
        $f = $reporte->fotos()->whereKey($foto)->firstOrFail();
        abort_unless(Storage::disk('reportes')->exists($f->ruta), 404);

        return response()->file(Storage::disk('reportes')->path($f->ruta), [
            'Content-Type'           => $f->mime,
            'Cache-Control'          => 'private, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /** Carga el reporte si el usuario puede verlo (admin: todos; encargado: su área). */
    private function autorizar(Request $request, int $id): Reporte
    {
        return Reporte::visiblesPara($request->user())->findOrFail($id);
    }
}
