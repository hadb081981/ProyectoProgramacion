@extends('portal.layout')

@section('title', 'Ingreso del personal')
@section('sin_ingreso', '1')

@push('estilos')
<style>
    .lg{display:grid;grid-template-columns:1.1fr 1fr;gap:40px;align-items:center;min-height:calc(100vh - 190px);}
    .lg-logo{width:84px;height:84px;border-radius:22px;display:block;margin-bottom:18px;box-shadow:0 0 0 3px rgba(255,255,255,.15), 0 18px 36px -14px rgba(0,0,0,.6);}
    .lg-txt h1{font-size:42px;line-height:1.1;font-weight:800;margin:0 0 12px;letter-spacing:-.5px;}
    .lg-txt h1 span{color:var(--am);}
    .lg-txt p{color:rgba(255,255,255,.78);font-size:17px;margin:0 0 24px;max-width:460px;}
    .lg-flujo{display:flex;gap:10px;flex-wrap:wrap;}
    .lg-flujo span{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:999px;background:var(--vidrio);border:1px solid var(--borde);font-weight:600;font-size:14px;}
    .lg-flujo i{color:var(--am);}
    .lg-card{max-width:430px;width:100%;justify-self:end;}
    .lg-card .lg-ico{width:56px;height:56px;border-radius:16px;background:var(--az);color:var(--am);display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:14px;}
    .lg-pass{position:relative;}
    .lg-pass button{position:absolute;right:8px;top:50%;transform:translateY(-50%);border:0;background:none;color:var(--mut);font-size:19px;cursor:pointer;padding:6px;}
    .lg-check{display:flex;gap:8px;align-items:center;margin-top:14px;color:var(--mut);font-size:14.5px;}
    @media (max-width:860px){
        .lg-logo{width:64px;height:64px;border-radius:17px;margin-bottom:12px;}
        .lg{grid-template-columns:1fr;gap:24px;min-height:0;margin-top:8px;}
        .lg-txt h1{font-size:30px;} .lg-txt p{font-size:15.5px;margin-bottom:16px;}
        .lg-card{justify-self:stretch;max-width:none;}
    }
</style>
@endpush

@section('contenido')
    <div class="lg">
        <section class="lg-txt">
            <img src="{{ asset('public/img/branding/atencion-ciudadana-icono.svg') }}" alt="Logotipo de Atención Ciudadana" class="lg-logo">
            <h1>Bandeja de <span>Atención Ciudadana</span></h1>
            <p>Ingrese para atender los reportes de los vecinos y dejarles comentarios sobre el avance.</p>
            <div class="lg-flujo">
                <span><i class="bi bi-inbox"></i> Recibido</span>
                <span><i class="bi bi-tools"></i> En proceso</span>
                <span><i class="bi bi-check-circle"></i> Resuelto</span>
            </div>
        </section>

        <section class="ry-card lg-card">
            <div class="lg-ico"><i class="bi bi-person-lock" aria-hidden="true"></i></div>
            <h2 style="margin-bottom:4px;">Ingreso del personal</h2>
            <p style="color:var(--mut);margin:0 0 6px;font-size:14.5px;">Use el correo y la contraseña de su usuario.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label class="ry-label" for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus maxlength="255"
                       class="ry-input @error('email') err @enderror" placeholder="usuario@morales.gob.gt">
                @error('email')<div class="ry-error">{{ $message }}</div>@enderror

                <label class="ry-label" for="password">Contraseña</label>
                <div class="lg-pass">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="ry-input @error('password') err @enderror" style="padding-right:44px;">
                    <button type="button" id="ver-pass" aria-label="Mostrar contraseña"><i class="bi bi-eye"></i></button>
                </div>
                @error('password')<div class="ry-error">{{ $message }}</div>@enderror

                <label class="lg-check"><input type="checkbox" name="remember" @checked(old('remember'))> Mantener la sesión iniciada</label>

                <button type="submit" class="ry-btn ry-btn-az ry-btn-full" style="margin-top:20px;"><i class="bi bi-box-arrow-in-right"></i> Ingresar</button>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('ver-pass').addEventListener('click', function () {
        var c = document.getElementById('password'), ver = c.type === 'password';
        c.type = ver ? 'text' : 'password';
        this.innerHTML = ver ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        this.setAttribute('aria-label', ver ? 'Ocultar contraseña' : 'Mostrar contraseña');
    });
</script>
@endpush
