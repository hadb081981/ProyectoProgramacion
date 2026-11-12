<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        // Fotos de los reportes: storage/app/private/reportes/{id}/{uuid}.jpg
        // Disco privado (no se sirve directo por la web): las fotos se muestran
        // solo por una ruta de Laravel que valida que el usuario pueda ver el reporte.
        'reportes' => [
            'driver' => 'local',
            'root' => storage_path('app/private/reportes'),
            'visibility' => 'private',
            'throw' => true,
        ],

    ],

];
