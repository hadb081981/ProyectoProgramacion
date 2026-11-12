@extends('portal.layout')

@section('title', 'Reportar un problema')

@push('estilos')
<style>
    .ry-cats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px;}
    .ry-cat input{position:absolute;opacity:0;pointer-events:none;}
    .ry-cat label{display:flex;flex-direction:column;gap:10px;height:100%;padding:18px;border-radius:18px;cursor:pointer;
        background:var(--vidrio);border:1.5px solid var(--borde);transition:background .15s, transform .15s, border-color .15s;}
    .ry-cat label:hover{background:var(--vidrio2);transform:translateY(-2px);}
    .ry-cat-ico{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:rgba(240,224,0,.14);color:var(--am);font-size:25px;}
    .ry-cat b{display:block;font-size:16.5px;font-weight:800;line-height:1.25;margin-bottom:3px;}
    .ry-cat small{display:block;color:rgba(255,255,255,.7);font-size:13.5px;line-height:1.35;}
    .ry-cat input:checked + label{background:var(--am);border-color:var(--am);color:var(--az);}
    .ry-cat input:checked + label .ry-cat-ico{background:var(--az);color:var(--am);}
    .ry-cat input:checked + label small{color:rgba(8,40,104,.8);}
    .ry-cat input:focus-visible + label{outline:3px solid #fff;outline-offset:2px;}
    .ry-cat-err{color:#fecaca;font-weight:700;margin:-12px 0 18px;}
    .ry-dos{display:grid;grid-template-columns:1fr 1fr;gap:0 14px;}
    .ry-foto{display:flex;align-items:center;gap:12px;padding:14px;border:1.5px dashed #cbd5e1;border-radius:12px;background:#f9fafb;cursor:pointer;}
    .ry-foto i{font-size:26px;color:var(--az);}
    .ry-foto input{font-size:14px;max-width:100%;}
    .ry-cols{display:grid;grid-template-columns:1.5fr 1fr;gap:18px;align-items:start;}
    .ry-hp{position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;}
    .ry-pasos-mini{display:grid;gap:12px;margin-top:16px;}
    .ry-pasos-mini div{display:flex;gap:12px;align-items:center;color:rgba(255,255,255,.85);font-size:14.5px;}
    .ry-pasos-mini i{width:36px;height:36px;border-radius:11px;background:var(--vidrio2);display:flex;align-items:center;justify-content:center;color:var(--am);font-size:17px;flex-shrink:0;}
    @media (max-width:900px){ .ry-cols{grid-template-columns:1fr;} }
    @media (max-width:640px){
        .ry-cats{grid-template-columns:1fr;gap:9px;}
        .ry-cat label{flex-direction:row;align-items:center;padding:13px 14px;gap:13px;}
        .ry-cat-ico{width:44px;height:44px;font-size:22px;flex-shrink:0;}
        .ry-cat small{display:block;}
        .ry-dos{grid-template-columns:1fr;}
    }
</style>
@endpush

@section('contenido')
    <section class="ry-hero">
        <h1>¿Qué problema <span>vio hoy?</span></h1>
        <p>Repórtelo en un minuto. Lo recibe el personal de la Municipalidad y usted consulta el avance con su folio.</p>
    </section>

    <form method="POST" action="{{ route('portal.enviar') }}" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="ry-hp" aria-hidden="true"><label>Sitio web <input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label></div>

        <h2><span class="ry-num">1</span> Elija el tipo de problema</h2>
        <div class="ry-cats" role="radiogroup" aria-label="Tipo de problema">
            @foreach ($categorias as $c)
                <div class="ry-cat">
                    <input type="radio" name="idcategoria" id="cat{{ $c->id }}" value="{{ $c->id }}" @checked((string) old('idcategoria') === (string) $c->id) required>
                    <label for="cat{{ $c->id }}">
                        <span class="ry-cat-ico"><i class="bi {{ $c->icono ?: 'bi-exclamation-circle' }}" aria-hidden="true"></i></span>
                        <span><b>{{ $c->nombre }}</b>@if ($c->descripcion)<small>{{ $c->descripcion }}</small>@endif</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('idcategoria')<div class="ry-cat-err">{{ $message }}</div>@enderror

        <div class="ry-cols">
            <div class="ry-card">
                <h2><span class="ry-num">2</span> Cuéntenos qué pasa</h2>

                @if ($errors->has('envio'))<div class="ry-alert ry-alert-err">{{ $errors->first('envio') }}</div>@endif
                @if ($errors->any() && !$errors->hasAny(['consulta', 'envio', 'folio', 'tel_consulta']))
                    <div class="ry-alert ry-alert-err">Revise los datos marcados en rojo.</div>
                @endif

                <label class="ry-label" for="descripcion" style="margin-top:0;">Describa el problema</label>
                <textarea id="descripcion" name="descripcion" rows="3" maxlength="1000" required class="ry-input @error('descripcion') err @enderror"
                          placeholder="Hay un bache grande frente a la escuela que ya causó accidentes.">{{ old('descripcion') }}</textarea>
                @error('descripcion')<div class="ry-error">{{ $message }}</div>@enderror

                <label class="ry-label" for="foto">Foto <small>(opcional · JPG o PNG, máx. 10 MB)</small></label>
                <label class="ry-foto @error('foto') err @enderror" for="foto">
                    <i class="bi bi-camera-fill" aria-hidden="true"></i>
                    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png">
                </label>
                @error('foto')<div class="ry-error">{{ $message }}</div>@enderror

                <div class="ry-dos">
                    <div>
                        <label class="ry-label" for="idcomunidad">Barrio o comunidad</label>
                        <select id="idcomunidad" name="idcomunidad" required class="ry-input @error('idcomunidad') err @enderror">
                            <option value="">Elija de la lista…</option>
                            @foreach (collect($comunidades)->groupBy('tipo') as $tipo => $grupo)
                                <optgroup label="{{ $tipo ?: 'Otros' }}">
                                    @foreach ($grupo as $co)
                                        <option value="{{ $co->id }}" @selected((string) old('idcomunidad') === (string) $co->id)>{{ $co->nombre }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('idcomunidad')<div class="ry-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="ry-label" for="referencia">Referencia <small>(opcional)</small></label>
                        <input type="text" id="referencia" name="referencia" maxlength="255" value="{{ old('referencia') }}"
                               class="ry-input @error('referencia') err @enderror" placeholder="Frente a la iglesia">
                        @error('referencia')<div class="ry-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="ry-dos">
                    <div>
                        <label class="ry-label" for="nombre">Su nombre</label>
                        <input type="text" id="nombre" name="nombre" maxlength="120" value="{{ old('nombre') }}" required autocomplete="name"
                               class="ry-input @error('nombre') err @enderror" placeholder="María López">
                        @error('nombre')<div class="ry-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="ry-label" for="telefono">Teléfono <small>(8 dígitos)</small></label>
                        <input type="tel" id="telefono" name="telefono" maxlength="9" inputmode="numeric" value="{{ old('telefono') }}" required autocomplete="tel"
                               class="ry-input @error('telefono') err @enderror" placeholder="5555 5555">
                        @error('telefono')<div class="ry-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="ry-btn ry-btn-az ry-btn-full" style="margin-top:22px;"><i class="bi bi-send-fill"></i> Enviar reporte</button>
            </div>

            <aside class="ry-oscura" id="consultar">
                <h2><span class="ry-num"><i class="bi bi-search" style="font-size:13px;"></i></span> ¿Ya reportó?</h2>
                <p style="color:rgba(255,255,255,.75);margin:-6px 0 4px;font-size:14.5px;">Consulte el avance con su folio y el teléfono que usó.</p>
                @error('consulta')<div class="ry-alert ry-alert-err" style="margin-top:12px;">{{ $message }}</div>@enderror
                <div id="consulta-campos">
                    <label class="ry-label" for="folio">Folio</label>
                    <input type="text" id="folio" form="form-consulta" name="folio" maxlength="30" value="{{ old('folio') }}" required class="ry-input" placeholder="INC-2026-000001">
                    @error('folio')<div class="ry-error">{{ $message }}</div>@enderror
                    <label class="ry-label" for="tel_consulta">Teléfono</label>
                    <input type="tel" id="tel_consulta" form="form-consulta" name="tel_consulta" maxlength="9" inputmode="numeric" required class="ry-input" placeholder="5555 5555">
                    @error('tel_consulta')<div class="ry-error">{{ $message }}</div>@enderror
                    <button type="submit" form="form-consulta" class="ry-btn ry-btn-full" style="margin-top:16px;"><i class="bi bi-search"></i> Consultar con mi folio</button>
                </div>
                <div class="ry-pasos-mini">
                    <div><i class="bi bi-inbox"></i> Recibido: llegó a la Municipalidad.</div>
                    <div><i class="bi bi-tools"></i> En proceso: el personal lo atiende.</div>
                    <div><i class="bi bi-check-circle"></i> Resuelto: el problema se solucionó.</div>
                </div>
            </aside>
        </div>
    </form>
    {{-- Formulario de consulta aparte (sus campos están dentro del panel lateral con el atributo form). --}}
    <form method="POST" action="{{ route('portal.consultar') }}" id="form-consulta">@csrf</form>
@endsection
