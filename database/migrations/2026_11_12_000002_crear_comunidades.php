<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Barrios, colonias, aldeas y caseríos que el vecino elige al reportar. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comunidades', function (Blueprint $t) {
            $t->id();
            $t->string('nombre', 120);
            $t->string('tipo', 30)->default('Barrio')->comment('Cabecera, Barrio, Colonia, Aldea, Caserío o Finca');
            $t->timestamp('baja')->nullable()->comment('Fecha en que se dio de baja; NULL = activa');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comunidades');
    }
};
