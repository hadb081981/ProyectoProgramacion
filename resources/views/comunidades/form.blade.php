@extends('adminlte::page')

@section('title', $comunidad->exists ? 'Editar comunidad' : 'Nueva comunidad')

@section('content')
@include('bandeja.estilos')
<div class="bs">
    <div class="bs-banda">
        <div>
            <a href="{{ route('comunidades.index') }}" style="color:rgba(255,255,255,.75);font-weight:600;font-size:14px;"><i class="bi bi-arrow-left"></i> Comunidades</a>
            <h1 style="margin-top:4px;"><i class="bi bi-houses-fill"></i> {{ $comunidad->exists ? 'Editar comunidad' : 'Nueva comunidad' }}</h1>
        </div>
    </div>

    <div class="bs-card bs-form">
        <form method="POST" action="{{ $comunidad->exists ? route('comunidades.update', $comunidad->id) : route('comunidades.store') }}">
            @csrf
            @if ($comunidad->exists) @method('PUT') @endif

            <label class="bs-label" for="nombre" style="margin-top:0;">Nombre</label>
            <input id="nombre" name="nombre" maxlength="120" required class="bs-input" value="{{ old('nombre', $comunidad->nombre) }}">
            @error('nombre')<div class="bs-error">{{ $message }}</div>@enderror

            <label class="bs-label" for="tipo">Tipo</label>
            <select id="tipo" name="tipo" class="bs-input" required>
                @foreach (\App\Models\Comunidad::TIPOS as $t)
                    <option value="{{ $t }}" @selected(old('tipo', $comunidad->tipo) === $t)>{{ $t }}</option>
                @endforeach
            </select>
            @error('tipo')<div class="bs-error">{{ $message }}</div>@enderror

            <button type="submit" class="bs-btn bs-btn-am" style="margin-top:20px;"><i class="bi bi-check2-circle"></i> Guardar</button>
        </form>
    </div>
</div>
@stop
