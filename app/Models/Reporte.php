<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Reporte de un vecino. Pasa por 3 estados: recibido → en_proceso → resuelto.
 * Folio visible: INC-AAAA-NNNNNN (año de creación + id con 6 dígitos).
 */
class Reporte extends Model
{
    protected $table = 'reportes';

    protected $fillable = ['idcategoria', 'idarea', 'idcomunidad', 'nombre', 'telefono', 'descripcion', 'referencia', 'estado', 'ip'];

    protected $casts = ['fecha_cierre' => 'datetime'];

    /** clave => [etiqueta, icono de Bootstrap Icons, fondo, texto] */
    public const ESTADOS = [
        'recibido'   => ['Recibido',   'bi-inbox',        '#fef3c7', '#b45309'],
        'en_proceso' => ['En proceso', 'bi-tools',        '#dbeafe', '#1d4ed8'],
        'resuelto'   => ['Resuelto',   'bi-check-circle', '#dcfce7', '#15803d'],
    ];

    /** Fotos: JPG o PNG de máximo 10 MB. */
    public const MIMES = 'jpg,jpeg,png';
    public const MAX_KB = 10240;

    // ------------------------------------------------------------ Relaciones

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'idcategoria');
    }

    public function comunidad(): BelongsTo
    {
        return $this->belongsTo(Comunidad::class, 'idcomunidad');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(ReporteFoto::class, 'idreporte');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(ReporteComentario::class, 'idreporte')->orderByDesc('id');
    }

    // ------------------------------------------------------------ Alcance por usuario

    /** El administrador ve todos los reportes; el encargado, solo los de su área. */
    public function scopeVisiblesPara(Builder $q, User $u): Builder
    {
        return $u->esAdmin() ? $q : $q->where('idarea', $u->idarea);
    }

    // ------------------------------------------------------------ Presentación

    public function getFolioAttribute(): string
    {
        return 'INC-' . $this->created_at->format('Y') . '-' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    /** Datos del estado para pintar el badge: clave, txt, ico, bg, fg. */
    public function getInfoEstadoAttribute(): array
    {
        return self::infoEstado($this->estado);
    }

    public static function infoEstado(?string $clave): array
    {
        $clave = isset(self::ESTADOS[$clave]) ? $clave : 'recibido';
        [$txt, $ico, $bg, $fg] = self::ESTADOS[$clave];
        return compact('clave', 'txt', 'ico', 'bg', 'fg');
    }

    // ------------------------------------------------------------ Utilidades

    /** Id a partir del folio que escribe el vecino ("INC-2026-000012", "2026-12" o "12"). */
    public static function idDeFolio(?string $folio): ?int
    {
        return preg_match('/^\s*(?:INC-?)?(?:\d{4}-?)?0*(\d{1,9})\s*$/i', (string) $folio, $m) ? (int) $m[1] : null;
    }

    /** Nombre en MAYÚSCULAS y sin tildes ("josé pérez" → "JOSE PEREZ"). Conserva la Ñ. */
    public static function normalizarNombre(?string $nombre): string
    {
        $t = mb_strtoupper(trim((string) $nombre), 'UTF-8');
        $t = strtr($t, ['Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U']);
        $t = preg_replace("/[^A-ZÑ .'\-]/u", '', $t);
        return trim(preg_replace('/\s+/u', ' ', $t));
    }

    /** Teléfono solo con dígitos; quita el código de país 502 si viene. */
    public static function limpiarTelefono(?string $tel): string
    {
        $d = preg_replace('/\D/', '', (string) $tel);
        return (strlen($d) === 11 && str_starts_with($d, '502')) ? substr($d, 3) : $d;
    }

    /** Guarda la foto con un nombre generado en storage/app/private/reportes/{id}/. */
    public function guardarFoto(UploadedFile $foto): ReporteFoto
    {
        $ext = in_array(strtolower((string) $foto->extension()), ['jpg', 'jpeg', 'png'], true) ? strtolower($foto->extension()) : 'jpg';
        $ruta = $foto->storeAs((string) $this->id, Str::uuid() . '.' . $ext, 'reportes');

        return $this->fotos()->create(['ruta' => $ruta, 'mime' => $foto->getMimeType() === 'image/png' ? 'image/png' : 'image/jpeg']);
    }

    /** Registra un cambio de estado (o un comentario) en el historial. */
    public function registrar(?int $idusuario, string $estadoNuevo, ?string $comentario): ReporteComentario
    {
        return $this->comentarios()->create([
            'idusuario'       => $idusuario,
            'estado_anterior' => $this->getOriginal('estado'),
            'estado_nuevo'    => $estadoNuevo,
            'comentario'      => $comentario !== null && trim($comentario) !== '' ? trim($comentario) : null,
        ]);
    }
}
