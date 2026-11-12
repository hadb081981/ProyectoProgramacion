@extends('adminlte::page')

@section('title', 'Reporte ' . $reporte->folio)

@section('content')
@include('bandeja.estilos')
<style>
.bs-grid{display:grid;grid-template-columns:1.35fr 1fr;gap:16px;align-items:start;}
.bs-dato{display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14.5px;}
.bs-dato:last-child{border-bottom:0;}
.bs-dato span{color:var(--mut);min-width:110px;font-weight:600;}
.bs-foto img{max-width:100%;border-radius:14px;border:1px solid var(--line);margin-top:10px;}
.bs-estados{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px;}
.bs-est input{position:absolute;opacity:0;pointer-events:none;}
.bs-est label{display:flex;flex-direction:column;align-items:center;gap:5px;padding:14px 6px;border:2px solid var(--line);border-radius:14px;
    cursor:pointer;font-weight:800;font-size:13.5px;text-align:center;margin:0;background:#f8fafc;color:#475569;transition:.12s;}
.bs-est label i{font-size:22px;}
.bs-est input:checked + label{background:var(--az);border-color:var(--az);color:#fff;}
.bs-est input:checked + label i{color:var(--am);}
.bs-est input:focus-visible + label{outline:3px solid var(--am);}
.bs-hist{border-left:3px solid #e2e8f0;padding:0 0 14px 16px;position:relative;margin-left:5px;}
.bs-hist:last-child{padding-bottom:0;}
.bs-hist:before{content:"";position:absolute;left:-8px;top:3px;width:13px;height:13px;border-radius:50%;background:var(--am);border:3px solid var(--az);}
.bs-hist small{color:var(--mut);font-weight:600;}
.bs-tel{display:inline-flex;gap:6px;align-items:center;font-weight:700;color:var(--az);}
@media (max-width:991px){ .bs-grid{grid-template-columns:1fr;} }
</style>
@php $e = $reporte->info_estado; @endphp
<div class="bs">
    @if (session('success'))<div class="bs-alert bs-ok">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="bs-alert bs-err">{{ $errors->first() }}</div>@endif

    <div class="bs-banda">
        <div>
            <a href="{{ route('bandeja.index') }}" style="color:rgba(255,255,255,.75);font-weight:600;font-size:14px;"><i class="bi bi-arrow-left"></i> Bandeja</a>
            <h1 style="margin-top:4px;"><i class="bi {{ $reporte->categoria->icono }}"></i> {{ $reporte->categoria->nombre }}</h1>
            <p>{{ $reporte->folio }} · {{ $reporte->comunidad->nombre ?? 'Sin comunidad' }}</p>
        </div>
        <span class="bs-badge" style="background:{{ $e['bg'] }};color:{{ $e['fg'] }};font-size:15px;padding:8px 16px;"><i class="bi {{ $e['ico'] }}"></i> {{ $e['txt'] }}</span>
    </div>

    <div class="bs-grid">
        <div>
            <div class="bs-card">
                <h2><i class="bi bi-card-text"></i> Datos del reporte</h2>
                <div class="bs-dato"><span>Descripción</span><div>{{ $reporte->descripcion }}</div></div>
                <div class="bs-dato"><span>Comunidad</span><div>{{ $reporte->comunidad->nombre ?? '—' }}@if ($reporte->comunidad) <small style="color:var(--mut);">({{ $reporte->comunidad->tipo }})</small>@endif</div></div>
                <div class="bs-dato"><span>Referencia</span><div>{{ $reporte->referencia ?: '—' }}</div></div>
                <div class="bs-dato"><span>Reportó</span><div>{{ $reporte->nombre }}</div></div>
                <div class="bs-dato"><span>Teléfono</span><div><a class="bs-tel" href="tel:{{ $reporte->telefono }}"><i class="bi bi-telephone-fill"></i> {{ $reporte->telefono }}</a></div></div>
                <div class="bs-dato"><span>Fecha</span><div>{{ $reporte->created_at->format('d/m/Y h:i a') }}</div></div>
                @foreach ($reporte->fotos as $f)
                    <div class="bs-foto"><a href="{{ route('bandeja.foto', [$reporte->id, $f->id]) }}" target="_blank" rel="noopener">
                        <img src="{{ route('bandeja.foto', [$reporte->id, $f->id]) }}" alt="Foto del reporte" loading="lazy"></a></div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="bs-card" style="border:2px solid var(--az);">
                <h2><i class="bi bi-arrow-repeat"></i> Cambiar estado</h2>
                <form method="POST" action="{{ route('bandeja.estado', $reporte->id) }}">
                    @csrf
                    <div class="bs-estados" role="radiogroup" aria-label="Nuevo estado">
                        @foreach (\App\Models\Reporte::ESTADOS as $k => [$txt, $ico])
                            <div class="bs-est">
                                <input type="radio" name="estado" id="e_{{ $k }}" value="{{ $k }}" @checked(old('estado', $e['clave']) === $k)>
                                <label for="e_{{ $k }}"><i class="bi {{ $ico }}"></i>{{ $txt }}</label>
                            </div>
                        @endforeach
                    </div>
                    <label for="comentario" style="font-weight:700;">Comentario para el vecino</label>
                    <textarea id="comentario" name="comentario" rows="3" maxlength="1000" class="bs-input" required
                              placeholder="El equipo de mantenimiento visitará el lugar esta semana.">{{ old('comentario') }}</textarea>
                    @error('comentario')<div class="bs-error">{{ $message }}</div>@enderror
                    <small style="color:var(--mut);display:block;margin:6px 0 14px;">El vecino lo verá al consultar con su folio y teléfono.</small>
                    <button type="submit" class="bs-btn bs-btn-am" style="width:100%;justify-content:center;"><i class="bi bi-check2-circle"></i> Guardar cambio</button>
                </form>
            </div>

            <div class="bs-card">
                <h2><i class="bi bi-clock-history"></i> Historial</h2>
                @foreach ($reporte->comentarios as $c)
                    <div class="bs-hist">
                        <small>{{ $c->created_at->format('d/m/Y h:i a') }} · {{ $c->usuario->name ?? 'Vecino' }}</small>
                        <div><b>{{ $c->estado_anterior === null ? 'Reporte recibido' : \App\Models\Reporte::infoEstado($c->estado_nuevo)['txt'] }}</b></div>
                        @if ($c->comentario)<div>{{ $c->comentario }}</div>@endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop
