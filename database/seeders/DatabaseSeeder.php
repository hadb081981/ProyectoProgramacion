<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Datos iniciales: áreas, las 4 categorías, comunidades, dos usuarios de prueba
 * y tres reportes de ejemplo con datos ficticios.
 *
 *   php artisan migrate --seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = now();

        // Áreas que atienden los reportes.
        $mant = DB::table('areas')->insertGetId(['nombre' => 'Mantenimiento', 'created_at' => $ahora, 'updated_at' => $ahora]);
        $elec = DB::table('areas')->insertGetId(['nombre' => 'Alumbrado público', 'created_at' => $ahora, 'updated_at' => $ahora]);
        $agua = DB::table('areas')->insertGetId(['nombre' => 'Agua potable', 'created_at' => $ahora, 'updated_at' => $ahora]);

        // Categorías (icono = clase de Bootstrap Icons).
        $cats = [
            ['Bacheo y calles', 'Baches, hundimientos o calles en mal estado.', 'bi-cone-striped', $mant],
            ['Alumbrado público', 'Lámparas apagadas, intermitentes o dañadas.', 'bi-lightbulb-off', $elec],
            ['Limpieza y recolección', 'Basura acumulada, falta de recolección o basureros clandestinos.', 'bi-trash3', $mant],
            ['Agua potable', 'Fugas, falta de agua o tuberías dañadas del servicio de agua potable.', 'bi-droplet-half', $agua],
        ];
        foreach ($cats as [$nombre, $desc, $icono, $area]) {
            DB::table('categorias')->insert(['nombre' => $nombre, 'descripcion' => $desc, 'icono' => $icono, 'idarea' => $area,
                'activo' => true, 'created_at' => $ahora, 'updated_at' => $ahora]);
        }

        $this->call(ComunidadSeeder::class);

        // Usuarios de prueba (SOLO para uso local: cambie las contraseñas en un servidor real).
        $admin = DB::table('users')->insertGetId(['name' => 'Administrador', 'email' => 'admin@atencionciudadana.test',
            'password' => Hash::make('Admin12345'), 'tipo_usuario' => 1, 'idarea' => null, 'created_at' => $ahora, 'updated_at' => $ahora]);
        DB::table('users')->insert(['name' => 'Encargado de Mantenimiento', 'email' => 'mantenimiento@atencionciudadana.test',
            'password' => Hash::make('Encargado12345'), 'tipo_usuario' => 0, 'idarea' => $mant, 'created_at' => $ahora, 'updated_at' => $ahora]);

        // Reportes de ejemplo (nombres y teléfonos ficticios).
        $com = fn (string $n) => DB::table('comunidades')->where('nombre', $n)->value('id');
        $ejemplos = [
            [1, $mant, $com('Caribe'), 'MARIA LOPEZ', '55551001', 'Bache grande frente a la escuela; los carros se desvían.', 'Frente a la escuela', 'recibido', null],
            [2, $elec, $com('Bananera'), 'JUAN PEREZ', '55551002', 'Tres lámparas apagadas en la calle principal desde hace una semana.', 'Calle principal', 'en_proceso', 'El equipo de alumbrado revisará las lámparas el jueves.'],
            [4, $agua, $com('Carrizal'), 'ANA GARCIA', '55551003', 'Fuga de agua en la tubería de la esquina.', 'Esquina del parque', 'resuelto', 'Se reparó la tubería. Gracias por reportarlo.'],
        ];
        foreach ($ejemplos as $i => [$cat, $area, $comunidad, $nombre, $tel, $desc, $ref, $estado, $comentario]) {
            $fecha = $ahora->copy()->subDays(3 - $i);
            $id = DB::table('reportes')->insertGetId(['idcategoria' => $cat, 'idarea' => $area, 'idcomunidad' => $comunidad,
                'nombre' => $nombre, 'telefono' => $tel, 'descripcion' => $desc, 'referencia' => $ref, 'estado' => $estado,
                'fecha_cierre' => $estado === 'resuelto' ? $ahora : null, 'created_at' => $fecha, 'updated_at' => $fecha]);
            DB::table('reporte_comentarios')->insert(['idreporte' => $id, 'idusuario' => null, 'estado_anterior' => null,
                'estado_nuevo' => 'recibido', 'comentario' => null, 'created_at' => $fecha]);
            if ($comentario) {
                DB::table('reporte_comentarios')->insert(['idreporte' => $id, 'idusuario' => $admin, 'estado_anterior' => 'recibido',
                    'estado_nuevo' => $estado, 'comentario' => $comentario, 'created_at' => $ahora]);
            }
        }
    }
}
