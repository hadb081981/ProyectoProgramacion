@extends('adminlte::page')

@section('title', $usuario->exists ? 'Editar usuario' : 'Nuevo usuario')

@section('content')
@include('bandeja.estilos')
<div class="bs">
    <div class="bs-banda">
        <div>
            <a href="{{ route('usuarios.index') }}" style="color:rgba(255,255,255,.75);font-weight:600;font-size:14px;"><i class="bi bi-arrow-left"></i> Usuarios</a>
            <h1 style="margin-top:4px;"><i class="bi bi-person-fill"></i> {{ $usuario->exists ? 'Editar usuario' : 'Nuevo usuario' }}</h1>
        </div>
    </div>

    <div class="bs-card bs-form">
        <form method="POST" action="{{ $usuario->exists ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}">
            @csrf
            @if ($usuario->exists) @method('PUT') @endif

            <label class="bs-label" for="name" style="margin-top:0;">Nombre completo</label>
            <input id="name" name="name" maxlength="120" required class="bs-input" value="{{ old('name', $usuario->name) }}">
            @error('name')<div class="bs-error">{{ $message }}</div>@enderror

            <label class="bs-label" for="email">Correo</label>
            <input id="email" type="email" name="email" maxlength="150" required class="bs-input" value="{{ old('email', $usuario->email) }}" autocomplete="off">
            @error('email')<div class="bs-error">{{ $message }}</div>@enderror

            <label class="bs-label" for="tipo_usuario">Tipo de usuario</label>
            <select id="tipo_usuario" name="tipo_usuario" class="bs-input" required>
                <option value="{{ \App\Models\User::ENCARGADO }}" @selected((int) old('tipo_usuario', $usuario->tipo_usuario) === \App\Models\User::ENCARGADO)>Encargado de área (atiende los reportes de su área)</option>
                <option value="{{ \App\Models\User::ADMIN }}" @selected((int) old('tipo_usuario', $usuario->tipo_usuario) === \App\Models\User::ADMIN)>Administrador (ve todo y gestiona usuarios y comunidades)</option>
            </select>
            @error('tipo_usuario')<div class="bs-error">{{ $message }}</div>@enderror

            <div id="campo-area">
                <label class="bs-label" for="idarea">Área que atiende</label>
                <select id="idarea" name="idarea" class="bs-input">
                    <option value="">Elija el área…</option>
                    @foreach ($areas as $a)
                        <option value="{{ $a->id }}" @selected((string) old('idarea', $usuario->idarea) === (string) $a->id)>{{ $a->nombre }}</option>
                    @endforeach
                </select>
                @error('idarea')<div class="bs-error">{{ $message }}</div>@enderror
            </div>

            <label class="bs-label" for="password">Contraseña @if ($usuario->exists)<small>(déjela en blanco para no cambiarla)</small>@else<small>(mínimo 8 caracteres)</small>@endif</label>
            <input id="password" type="password" name="password" maxlength="255" class="bs-input" autocomplete="new-password" @required(!$usuario->exists)>
            @error('password')<div class="bs-error">{{ $message }}</div>@enderror

            <button type="submit" class="bs-btn bs-btn-am" style="margin-top:20px;"><i class="bi bi-check2-circle"></i> Guardar</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // El área solo aplica a los encargados: el administrador ve todas.
    (function () {
        var tipo = document.getElementById('tipo_usuario'), area = document.getElementById('campo-area');
        function actualizar() { area.style.display = tipo.value === '{{ \App\Models\User::ADMIN }}' ? 'none' : ''; }
        tipo.addEventListener('change', actualizar);
        actualizar();
    })();
</script>
@stop
