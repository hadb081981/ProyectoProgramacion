<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#082868">
    <title>@yield('title', 'Inicio') · Atención Ciudadana</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('public/img/branding/atencion-ciudadana-icono.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Diseño C "Contraste moderno": azul profundo, acentos amarillos y botones grandes tipo app --}}
    <style>
        .ry{--az:#082868;--az2:#0b3485;--az3:#123f9a;--am:#f0e000;--vd:#009000;--txt:#1f2937;--mut:#6b7280;--line:#e5e7eb;
            --vidrio:rgba(255,255,255,.08);--vidrio2:rgba(255,255,255,.14);--borde:rgba(255,255,255,.16);}
        *{box-sizing:border-box;}
        html,body{margin:0;}
        body.ry{background:var(--az);color:#fff;font-family:"Plus Jakarta Sans",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;font-size:16px;line-height:1.5;
            background-image:radial-gradient(900px 500px at 110% -10%, rgba(240,224,0,.12), transparent 60%),
                             radial-gradient(700px 500px at -20% 30%, rgba(18,63,154,.9), transparent 70%);
            background-attachment:fixed;min-height:100vh;}
        .ry a{color:var(--am);}
        .ry-top{max-width:1040px;margin:0 auto;padding:16px;display:flex;align-items:center;gap:12px;}
        .ry-top img{width:46px;height:46px;border-radius:13px;display:block;box-shadow:0 0 0 2px rgba(255,255,255,.18);}
        .ry-marca b{display:flex;align-items:center;gap:7px;font-size:19px;font-weight:800;letter-spacing:.2px;}
        .ry-marca b:after{content:"";width:9px;height:9px;border-radius:50%;background:var(--am);}
        .ry-marca small{display:block;color:rgba(255,255,255,.7);font-size:12.5px;}
        .ry-top .ry-ingreso{margin-left:auto;color:#fff;font-size:14px;font-weight:600;text-decoration:none;display:inline-flex;gap:7px;align-items:center;
            padding:8px 14px;border:1px solid var(--borde);border-radius:999px;background:var(--vidrio);}
        .ry-top .ry-ingreso:hover{background:var(--vidrio2);}
        .ry-main{max-width:1040px;margin:0 auto;padding:8px 16px 48px;}
        .ry-hero h1{font-size:40px;line-height:1.1;font-weight:800;margin:18px 0 10px;letter-spacing:-.5px;}
        .ry-hero h1 span{color:var(--am);}
        .ry-hero p{color:rgba(255,255,255,.78);font-size:17px;max-width:620px;margin:0 0 26px;}
        .ry-card{background:#fff;color:var(--txt);border-radius:20px;padding:24px;box-shadow:0 24px 50px -24px rgba(0,0,0,.55);}
        .ry-card a{color:var(--az);}
        .ry-oscura{background:var(--vidrio);border:1px solid var(--borde);border-radius:20px;padding:22px;}
        .ry h2{font-size:20px;font-weight:800;margin:0 0 14px;display:flex;gap:10px;align-items:center;}
        .ry-card h2{color:var(--az);}
        .ry-num{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:var(--am);color:var(--az);font-size:14px;font-weight:800;flex-shrink:0;}
        .ry-label{display:block;font-weight:700;margin:16px 0 6px;font-size:15px;}
        .ry-label small{font-weight:500;color:var(--mut);}
        .ry-input{width:100%;padding:13px 14px;border:1.5px solid var(--line);border-radius:12px;font-size:16px;background:#f9fafb;color:var(--txt);font-family:inherit;}
        .ry-input:focus{outline:none;border-color:var(--az);background:#fff;box-shadow:0 0 0 4px rgba(240,224,0,.45);}
        .ry-input.err{border-color:#ef4444;background:#fef2f2;}
        .ry-oscura .ry-input{background:rgba(255,255,255,.95);}
        .ry-error{color:#b91c1c;font-size:14px;margin-top:5px;font-weight:600;}
        .ry-oscura .ry-error{color:#fecaca;}
        .ry-btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;border:0;border-radius:14px;padding:15px 22px;font-weight:800;font-size:16.5px;
            background:var(--am);color:var(--az) !important;cursor:pointer;text-decoration:none;font-family:inherit;transition:transform .12s, filter .12s;}
        .ry-btn:hover{filter:brightness(1.05);transform:translateY(-1px);}
        .ry-btn-az{background:var(--az);color:#fff !important;}
        .ry-btn-sec{background:var(--vidrio);color:#fff !important;border:1px solid var(--borde);}
        .ry-btn-full{width:100%;}
        .ry-alert{padding:12px 14px;border-radius:12px;margin-bottom:16px;font-size:15px;font-weight:600;}
        .ry-alert-err{background:#fef2f2;color:#991b1b;border:1px solid #fecaca;}
        .ry-badge{display:inline-flex;align-items:center;gap:7px;padding:6px 14px;border-radius:999px;font-weight:800;font-size:14px;}
        .ry-pie{text-align:center;color:rgba(255,255,255,.55);font-size:13px;margin-top:34px;}
        @media (max-width:640px){
            .ry-hero h1{font-size:31px;} .ry-hero p{font-size:15.5px;}
            .ry-card,.ry-oscura{padding:18px;border-radius:18px;}
            .ry-top .ry-ingreso span{display:none;}
        }
    </style>
    @stack('estilos')
</head>
<body class="ry">
    <header class="ry-top">
        <a href="{{ route('portal.inicio') }}"><img src="{{ asset('public/img/branding/atencion-ciudadana-icono.svg') }}" alt="Logotipo de Atención Ciudadana"></a>
        <div class="ry-marca">
            <b>Atención Ciudadana</b>
            <small>Reporta · Sigue · Resuelve</small>
        </div>
        @hasSection('sin_ingreso')
            <a class="ry-ingreso" href="{{ route('portal.inicio') }}"><i class="bi bi-megaphone"></i> <span>Hacer un reporte</span></a>
        @else
            <a class="ry-ingreso" href="{{ route('login') }}" title="Ingreso del personal"><i class="bi bi-person-lock"></i> <span>Personal</span></a>
        @endif
    </header>
    <main class="ry-main">
        @yield('contenido')
        <p class="ry-pie">Atención Ciudadana · Reportes de la comunidad</p>
    </main>
    @stack('scripts')
</body>
</html>
