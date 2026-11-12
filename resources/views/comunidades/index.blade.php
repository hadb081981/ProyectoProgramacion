@extends('adminlte::page')

@section('title', 'Comunidades')

@section('content')
@include('bandeja.estilos')
<div class="bs">
    @if (session('success'))<div class="bs-alert bs-ok">{{ session('success') }}</div>@endif

    <div class="bs-banda">
        <div>
            <h1><i class="bi bi-houses-fill"></i> Barrios y comunidades</h1>
            <p>{{ $comunidades->count() }} activas. Son las opciones que ve el vecino al reportar.</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <form method="GET" action="{{ route('comunidades.index') }}" style="display:flex;gap:8px;">
                <input type="search" name="q" value="{{ $q }}" maxlength="60" class="bs-input" style="border:0;" placeholder="Buscar por nombre" aria-label="Buscar comunidad">
                <button class="bs-btn bs-btn-am" type="submit" aria-label="Buscar"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('comunidades.create') }}" class="bs-btn bs-btn-am"><i class="bi bi-plus-lg"></i> Nueva</a>
        </div>
    </div>

    <div class="bs-card" style="padding:6px 8px;">
        <table class="bs-tabla">
            <thead><tr><th>Nombre</th><th>Tipo</th><th></th></tr></thead>
            <tbody>
            @forelse ($comunidades as $c)
                <tr>
                    <td><b>{{ $c->nombre }}</b></td>
                    <td>{{ $c->tipo }}</td>
                    <td>
                        <div class="bs-acciones">
                            <a href="{{ route('comunidades.edit', $c->id) }}" class="bs-btn bs-btn-sec bs-btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                            <form method="POST" action="{{ route('comunidades.baja', $c->id) }}" onsubmit="return confirm('¿Dar de baja «{{ $c->nombre }}»? Ya no aparecerá en el portal.');">
                                @csrf
                                <button class="bs-btn bs-btn-peligro bs-btn-sm" type="submit"><i class="bi bi-archive"></i> Dar de baja</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;color:var(--mut);padding:26px;">No hay comunidades {{ $q !== '' ? 'que coincidan' : 'registradas' }}.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
