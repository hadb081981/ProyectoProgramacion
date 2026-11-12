@extends('portal.layout')

@section('title', 'Estado de mi reporte')

@push('estilos')
<style>
    .ry-pasos{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:20px 0 4px;position:relative;}
    .ry-paso{text-align:center;padding:14px 6px;border-radius:14px;background:var(--vidrio);border:1px solid var(--borde);color:rgba(255,255,255,.5);font-weight:700;font-size:14px;}
    .ry-paso i{display:block;font-size:24px;margin-bottom:4px;}
    .ry-paso.on{color:#fff;background:var(--vidrio2);}
    .ry-paso.on i{color:var(--am);}
    .ry-paso.actual{background:var(--am);border-color:var(--am);color:var(--az);}
    .ry-dato{display:flex;gap:10px;color:var(--mut);font-size:15px;margin-top:8px;align-items:center;}
    .ry-dato i{color:var(--az);}
    .ry-dato b{color:var(--txt);}
    .ry-com{border-left:4px solid var(--am);background:#f8fafc;border-radius:0 12px 12px 0;padding:12px 14px;margin-top:10px;}
    .ry-com small{color:var(--mut);font-weight:600;}
    .ry-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-top:18px;align-items:start;}
    @media (max-width:760px){ .ry-grid{grid-template-columns:1fr;} }
</style>
@endpush

@section('contenido')
    @php
        $e = $reporte->info_estado;
        $pasos = array_keys(\App\Models\Reporte::ESTADOS);
        $actual = array_search($e['clave'], $pasos, true);
    @endphp

    <section>
        <small style="color:rgba(255,255,255,.7);font-weight:600;">Folio</small>
        <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center;">
            <h1 style="margin:0;font-size:32px;font-weight:800;">{{ $reporte->folio }}</h1>
            <span class="ry-badge" style="background:{{ $e['bg'] }};color:{{ $e['fg'] }};"><i class="bi {{ $e['ico'] }}"></i> {{ $e['txt'] }}</span>
        </div>
        <div class="ry-pasos" aria-label="Avance del reporte">
            @foreach (\App\Models\Reporte::ESTADOS as $k => [$txt, $ico])
                @php $n = array_search($k, $pasos, true); @endphp
                <div class="ry-paso {{ $n < $actual ? 'on' : '' }} {{ $n === $actual ? 'actual' : '' }}"><i class="bi {{ $ico }}"></i>{{ $txt }}</div>
            @endforeach
        </div>
    </section>

    <div class="ry-grid">
        <section class="ry-card">
            <h2><i class="bi {{ $reporte->categoria->icono }}"></i> {{ $reporte->categoria->nombre }}</h2>
            <div class="ry-dato"><i class="bi bi-geo-alt-fill"></i> <b>{{ $reporte->comunidad->nombre ?? 'Sin comunidad' }}</b>@if ($reporte->referencia) · {{ $reporte->referencia }}@endif</div>
            <div class="ry-dato"><i class="bi bi-calendar3"></i> Reportado el {{ $reporte->created_at->format('d/m/Y h:i a') }}</div>
            <p style="margin:14px 0 0;">{{ $reporte->descripcion }}</p>
        </section>

        <section class="ry-card">
            <h2><i class="bi bi-chat-left-text-fill"></i> Comentarios del personal</h2>
            @forelse ($comentarios as $c)
                <div class="ry-com">
                    <small>{{ $c->created_at->format('d/m/Y h:i a') }} · {{ \App\Models\Reporte::infoEstado($c->estado_nuevo)['txt'] }}</small>
                    <div>{{ $c->comentario }}</div>
                </div>
            @empty
                <p style="color:var(--mut);margin:0;">Su reporte fue recibido. Aquí verá los comentarios cuando el personal lo atienda.</p>
            @endforelse
        </section>
    </div>

    <p style="text-align:center;margin-top:22px;"><a href="{{ route('portal.inicio') }}" class="ry-btn ry-btn-sec"><i class="bi bi-arrow-left"></i> Volver al inicio</a></p>
@endsection
