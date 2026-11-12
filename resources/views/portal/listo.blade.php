@extends('portal.layout')

@section('title', 'Reporte enviado')

@section('contenido')
    <section style="max-width:560px;margin:24px auto 0;text-align:center;">
        <div style="width:84px;height:84px;border-radius:50%;background:var(--am);color:var(--az);display:flex;align-items:center;justify-content:center;font-size:44px;margin:0 auto 14px;">
            <i class="bi bi-check-lg" aria-hidden="true"></i></div>
        <h1 style="font-size:34px;font-weight:800;margin:0 0 6px;">¡Reporte enviado!</h1>
        <p style="color:rgba(255,255,255,.78);margin:0 0 22px;">Gracias por ayudarnos a mejorar su comunidad.</p>

        <div class="ry-card">
            <small style="color:var(--mut);font-weight:600;">Su folio es</small>
            <div style="font-size:clamp(22px,7vw,32px);white-space:nowrap;font-weight:800;color:var(--az);letter-spacing:1px;margin:2px 0 10px;">{{ $folio }}</div>
            <p style="color:var(--mut);margin:0;font-size:14.5px;">Guárdelo o tómele captura. Para consultar el avance necesitará este folio y el teléfono que escribió.</p>
        </div>

        <div style="display:grid;gap:10px;margin-top:18px;">
            <a href="{{ route('portal.inicio') }}#consultar" class="ry-btn ry-btn-full"><i class="bi bi-search"></i> Consultar mi reporte</a>
            <a href="{{ route('portal.inicio') }}" class="ry-btn ry-btn-sec ry-btn-full"><i class="bi bi-plus-circle"></i> Hacer otro reporte</a>
        </div>
    </section>
@endsection
