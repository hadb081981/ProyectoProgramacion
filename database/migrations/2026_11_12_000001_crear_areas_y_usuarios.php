<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Áreas de la municipalidad que atienden los reportes y usuarios del panel.
 * tipo_usuario: 1 = administrador (ve todo y gestiona usuarios y comunidades),
 *               0 = encargado (atiende solo los reportes de su área).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $t) {
            $t->id();
            $t->string('nombre', 120);
            $t->timestamps();
        });

        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name', 120);
            $t->string('email', 150)->unique();
            $t->string('password');
            $t->unsignedTinyInteger('tipo_usuario')->default(0);
            $t->foreignId('idarea')->nullable()->constrained('areas')->nullOnDelete();
            $t->timestamp('baja')->nullable()->comment('Fecha en que se dio de baja; NULL = activo');
            $t->rememberToken();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('areas');
    }
};
