<?php

// Mensajes de validación en español. Cubre las reglas que usa el sistema.
return [
    'accepted'   => 'Debe aceptar :attribute.',
    'array'      => ':Attribute debe ser una lista.',
    'boolean'    => ':Attribute debe ser verdadero o falso.',
    'confirmed'  => 'La confirmación de :attribute no coincide.',
    'date'       => ':Attribute no es una fecha válida.',
    'email'      => ':Attribute debe ser un correo electrónico válido.',
    'exists'     => 'El valor seleccionado en :attribute no existe.',
    'file'       => ':Attribute debe ser un archivo.',
    'image'      => ':Attribute debe ser una imagen.',
    'in'         => 'El valor seleccionado en :attribute no es válido.',
    'integer'    => ':Attribute debe ser un número entero.',
    'max'        => [
        'array'   => ':Attribute no puede tener más de :max elementos.',
        'file'    => ':Attribute no puede pesar más de :max KB.',
        'numeric' => ':Attribute no puede ser mayor que :max.',
        'string'  => ':Attribute no puede tener más de :max caracteres.',
    ],
    'mimes'      => ':Attribute debe ser un archivo de tipo: :values.',
    'mimetypes'  => ':Attribute debe ser un archivo de tipo: :values.',
    'min'        => [
        'array'   => ':Attribute debe tener al menos :min elementos.',
        'file'    => ':Attribute debe pesar al menos :min KB.',
        'numeric' => ':Attribute debe ser al menos :min.',
        'string'  => ':Attribute debe tener al menos :min caracteres.',
    ],
    'numeric'    => ':Attribute debe ser un número.',
    'regex'      => 'El formato de :attribute no es válido.',
    'required'   => 'Debe ingresar :attribute.',
    'same'       => ':Attribute y :other deben coincidir.',
    'size'       => [
        'string'  => ':Attribute debe tener :size caracteres.',
    ],
    'string'     => ':Attribute debe ser texto.',
    'unique'     => 'Ya existe un registro con ese valor de :attribute.',
    'uploaded'   => 'No se pudo subir :attribute.',

    'custom' => [],

    // Nombres legibles de los campos.
    'attributes' => [
        'idcategoria'  => 'la categoría',
        'idcomunidad'  => 'la comunidad',
        'idarea'       => 'el área',
        'descripcion'  => 'la descripción',
        'referencia'   => 'la referencia',
        'nombre'       => 'el nombre',
        'telefono'     => 'el teléfono',
        'foto'         => 'la foto',
        'folio'        => 'el folio',
        'tel_consulta' => 'el teléfono',
        'estado'       => 'el estado',
        'comentario'   => 'el comentario',
        'name'         => 'el nombre',
        'email'        => 'el correo',
        'password'     => 'la contraseña',
        'tipo_usuario' => 'el tipo de usuario',
        'tipo'         => 'el tipo',
    ],
];
