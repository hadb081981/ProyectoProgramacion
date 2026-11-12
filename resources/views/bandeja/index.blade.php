@extends('adminlte::page')

@section('title', 'Bandeja de reportes')

@section('content')
@include('bandeja.estilos')
<style>
.bs-buscar{display:flex;gap:8px;min-width:280px;flex:0 1 420px;}
.bs-buscar .bs-input{border:0;}
.bs-tablero{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;align-items:start;}
.bs-col{background:#e8edf5;border-radius:16px;padding:12px;}
.bs-col-cab{display:flex;justify-content:space-between;align-items:center;padding:2px 4px 10px;font-weight:800;font-size:15px;}
.bs-col-cab span{display:inline-flex;gap:7px;align-items:center;}
.bs-col-cab b{background:#fff;border-radius:999px;padding:2px 10px;font-size:13px;}
.bs-tarj{display:block;background:#fff;border-radius:12px;padding:12px 13px;margin-bottom:9px;border-left:4px solid;text-decoration:none !important;color:var(--txt) !important;
    box-shadow:0 2px 6px -3px rgba(8,40,104,.25);transition:transform .12s, box-shadow .12s;}
.bs-tarj:hover{transform:translateY(-2px);box-shadow:0 10px 18px -10px rgba(8,40,104,.45);}
.bs-tarj-top{display:flex;justify-content:space-between;gap:8px;align-items:center;}
.bs-tarj-cat{display:inline-flex;gap:7px;align-items:center;font-weight:800;font-size:14.5px;}
.bs-tarj-cat i{color:var(--az);font-size:17px;}
.bs-folio{font-size:12px;font-weight:700;color:var(--mut);}
.bs-desc{font-size:13.5px;color:#374151;margin:5px 0 7px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.bs-meta{display:flex;gap:10px;flex-wrap:wrap;color:var(--mut);font-size:12.5px;}
.bs-vacio{text-align:center;color:var(--mut);padding:22px 8px;font-size:14px;border:2px dashed #cbd5e1;border-radius:12px;}
.bs-mas{text-align:center;font-size:13px;color:var(--mut);padding:4px;}
@media (max-width:991px){ .bs-tablero{grid-template-columns:1fr;} }
</style>
@php
    $bordes = ['recibido' => '#f59e0b', 'en_proceso' => '#3b82f6', 'resuelto' => '#22c55e'];
    $maxCol = 30;
@endphp
<div class="bs">
    @if (session('success'))<div class="bs-alert bs-ok">{{ session('success') }}</div>@endif

    <div class="bs-banda">
        <div>
            <h1><i class="bi bi-inbox-fill"></i> Bandeja de reportes</h1>
            <p>Abra un reporte para cambiar su estado y dejar un comentario al vecino.</p>
        </div>
        <form method="GET" action="{{ route('bandeja.index') }}" class="bs-buscar">
            <input type="search" name="q" value="{{ $q }}" maxlength="60" class="bs-input" placeholder="Folio, nombre, teléfono o comunidad" aria-label="Buscar reportes">
            <button class="bs-btn bs-btn-am" type="submit" aria-label="Buscar"><i class="bi bi-search"></i></button>
        </form>
    </div>
    @if ($q !== '')
        <p style="margin:-4px 0 14px;">Resultados para <b>“{{ $q }}”</b> · <a href="{{ route('bandeja.index') }}">Quitar búsqueda</a></p>
    @endif

    <div class="bs-tablero">
        @foreach (\App\Models\Reporte::ESTADOS as $k => [$txt, $ico, $bg, $fg])
            @php $items = $columnas->get($k, collect()); @endphp
            <section class="bs-col" aria-label="{{ $txt }}">
                <div class="bs-col-cab" style="color:{{ $fg }};"><span><i class="bi {{ $ico }}"></i> {{ $txt }}</span><b>{{ $items->count() }}</b></div>
                @forelse ($items->take($maxCol) as $r)
                    <a href="{{ route('bandeja.show', $r->id) }}" class="bs-tarj" style="border-left-color:{{ $bordes[$k] }};">
                        <div class="bs-tarj-top">
                            <span class="bs-tarj-cat"><i class="bi {{ $r->categoria->icono }}"></i> {{ $r->categoria->nombre }}</span>
                            <span class="bs-folio">{{ $r->folio }}</span>
                        </div>
                        <div class="bs-desc">{{ $r->descripcion }}</div>
                        <div class="bs-meta">
                            <span><i class="bi bi-geo-alt"></i> {{ $r->comunidad->nombre ?? 'Sin comunidad' }}</span>
                            <span><i class="bi bi-person"></i> {{ $r->nombre }}</span>
                            <span><i class="bi bi-clock"></i> {{ $r->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="bs-vacio">Sin reportes {{ $q !== '' ? 'que coincidan' : 'aquí' }}.</div>
                @endforelse
                @if ($items->count() > $maxCol)
                    <div class="bs-mas">Se muestran {{ $maxCol }} de {{ $items->count() }}. Use el buscador para encontrar otros.</div>
                @endif
            </section>
        @endforeach
    </div>
</div>
@stop
