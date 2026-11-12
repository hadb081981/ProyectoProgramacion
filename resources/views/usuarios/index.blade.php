@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
@include('bandeja.estilos')
<div class="bs">
    @if (session('success'))<div class="bs-alert bs-ok">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="bs-alert bs-err">{{ session('error') }}</div>@endif

    <div class="bs-banda">
        <div>
            <h1><i class="bi bi-people-fill"></i> Usuarios</h1>
            <p>Administradores (ven todo) y encargados (atienden los reportes de su área).</p>
        </div>
        <a href="{{ route('usuarios.create') }}" class="bs-btn bs-btn-am"><i class="bi bi-person-plus-fill"></i> Nuevo usuario</a>
    </div>

    <div class="bs-card" style="padding:6px 8px;">
        <table class="bs-tabla">
            <thead><tr><th>Nombre</th><th class="bs-ocultar-movil">Correo</th><th>Tipo</th><th></th></tr></thead>
            <tbody>
            @foreach ($usuarios as $u)
                <tr>
                    <td><b>{{ $u->name }}</b></td>
                    <td class="bs-ocultar-movil">{{ $u->email }}</td>
                    <td>
                        @if ($u->esAdmin())
                            <span class="bs-badge" style="background:#e0e7ff;color:#082868;">Administrador</span>
                        @else
                            <span class="bs-badge" style="background:#f1f5f9;color:#334155;">Encargado · {{ $u->area->nombre ?? 'sin área' }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="bs-acciones">
                            <a href="{{ route('usuarios.edit', $u->id) }}" class="bs-btn bs-btn-sec bs-btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                            @if ($u->id !== auth()->id())
                                <form method="POST" action="{{ route('usuarios.baja', $u->id) }}" onsubmit="return confirm('¿Dar de baja a {{ $u->name }}? Ya no podrá iniciar sesión.');">
                                    @csrf
                                    <button class="bs-btn bs-btn-peligro bs-btn-sm" type="submit"><i class="bi bi-person-x"></i> Dar de baja</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
