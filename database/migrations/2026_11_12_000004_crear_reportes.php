<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Reportes de los vecinos, su foto y el historial de comentarios.
 * Estados: recibido → en_proceso → resuelto.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('idcategoria')->constrained('categorias');
            $t->foreignId('idarea')->nullable()->constrained('areas')->nullOnDelete();
            $t->foreignId('idcomunidad')->nullable()->constrained('comunidades')->nullOnDelete();
            $t->string('nombre', 120);
            $t->string('telefono', 8);
            $t->text('descripcion');
            $t->string('referencia', 255)->nullable();
            $t->string('estado', 15)->default('recibido')->index();
            $t->string('ip', 45)->nullable();
            $t->timestamp('fecha_cierre')->nullable();
            $t->timestamps();
        });

        Schema::create('reporte_fotos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('idreporte')->constrained('reportes')->cascadeOnDelete();
            $t->string('ruta', 255)->comment('Ruta dentro del disco privado "reportes"');
            $t->string('mime', 30);
            $t->timestamp('created_at')->nullable();
        });

        // Cada cambio de estado lleva un comentario que el vecino ve al consultar su folio.
        Schema::create('reporte_comentarios', function (Blueprint $t) {
            $t->id();
            $t->foreignId('idreporte')->constrained('reportes')->cascadeOnDelete();
            $t->foreignId('idusuario')->nullable()->constrained('users')->nullOnDelete()->comment('NULL = lo registró el vecino');
            $t->string('estado_anterior', 15)->nullable();
            $t->string('estado_nuevo', 15);
            $t->text('comentario')->nullable();
            $t->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_comentarios');
        Schema::dropIfExists('reporte_fotos');
        Schema::dropIfExists('reportes');
    }
};
