{{-- Diseño C "Contraste moderno" para la bandeja (prefijo bs) --}}
<style>
.bs{--az:#082868;--am:#f0e000;--txt:#1f2937;--mut:#6b7280;--line:#e5e7eb;color:var(--txt);padding-top:10px;font-family:"Plus Jakarta Sans","Source Sans 3",system-ui,sans-serif;}
.bs-banda{background:var(--az);color:#fff;border-radius:18px;padding:20px 22px;display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:center;margin-bottom:16px;
    background-image:radial-gradient(500px 220px at 100% 0, rgba(240,224,0,.16), transparent 60%);}
.bs-banda h1{font-size:24px;font-weight:800;margin:0;display:flex;gap:10px;align-items:center;color:#fff;}
.bs-banda h1 i{color:var(--am);}
.bs-banda p{margin:4px 0 0;color:rgba(255,255,255,.75);font-size:14.5px;}
.bs-card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:18px;box-shadow:0 10px 26px -20px rgba(8,40,104,.5);margin-bottom:16px;}
.bs-card h2{font-size:16.5px;font-weight:800;color:var(--az);margin:0 0 12px;display:flex;gap:8px;align-items:center;}
.bs-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:999px;font-weight:800;font-size:13px;white-space:nowrap;}
.bs-btn{display:inline-flex;align-items:center;gap:7px;border:0;border-radius:12px;padding:11px 16px;font-weight:800;font-size:14.5px;background:var(--az);color:#fff !important;text-decoration:none !important;cursor:pointer;}
.bs-btn-am{background:var(--am);color:var(--az) !important;}
.bs-btn-sec{background:#fff;color:var(--az) !important;border:1.5px solid var(--line);}
.bs-input{width:100%;padding:11px 13px;border:1.5px solid var(--line);border-radius:12px;font-size:15px;background:#fff;}
.bs-input:focus{outline:none;border-color:var(--az);box-shadow:0 0 0 4px rgba(240,224,0,.4);}
.bs-alert{padding:12px 14px;border-radius:12px;margin-bottom:14px;font-weight:600;}
.bs-ok{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;}
.bs-err{background:#fef2f2;color:#991b1b;border:1px solid #fecaca;}
.bs-error{color:#b91c1c;font-size:13.5px;margin-top:4px;font-weight:600;}
</style>
{{-- Tablas y formularios de los catálogos (comunidades y usuarios) --}}
<style>
.bs-tabla{width:100%;border-collapse:collapse;font-size:14.5px;}
.bs-tabla th{text-align:left;color:var(--mut);font-weight:700;font-size:13px;padding:10px 12px;border-bottom:2px solid var(--line);}
.bs-tabla td{padding:11px 12px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.bs-tabla tr:hover td{background:#f8fafc;}
.bs-acciones{display:flex;gap:6px;justify-content:flex-end;flex-wrap:wrap;}
.bs-acciones form{margin:0;}
.bs-btn-sm{padding:7px 11px;font-size:13px;border-radius:10px;}
.bs-btn-peligro{background:#fff;color:#b91c1c !important;border:1.5px solid #fecaca;}
.bs-label{display:block;font-weight:700;margin:14px 0 6px;}
.bs-label small{font-weight:500;color:var(--mut);}
.bs-form{max-width:560px;}
@media (max-width:640px){ .bs-tabla .bs-ocultar-movil{display:none;} }
</style>
