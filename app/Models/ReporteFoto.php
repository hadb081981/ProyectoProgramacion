<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Foto del reporte, guardada en el disco privado "reportes" con un nombre generado. */
class ReporteFoto extends Model
{
    protected $table = 'reporte_fotos';

    public const UPDATED_AT = null;

    protected $fillable = ['idreporte', 'ruta', 'mime'];
}
