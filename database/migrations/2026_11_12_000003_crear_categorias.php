<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Tipos de problema (bache, alumbrado, basura, agua) y el área que los atiende. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $t) {
            $t->id();
            $t->string('nombre', 80);
            $t->string('descripcion', 255)->nullable();
            $t->string('icono', 40)->default('bi-exclamation-circle')->comment('Clase de Bootstrap Icons');
            $t->foreignId('idarea')->nullable()->constrained('areas')->nullOnDelete();
            $t->boolean('activo')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
