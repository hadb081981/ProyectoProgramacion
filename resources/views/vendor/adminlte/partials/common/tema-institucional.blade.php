{{-- Tema institucional del sistema interno (menú lateral y barra superior).
     Colores del logotipo: azul #082868, verde #009000, amarillo #f0e000. --}}
<style>
:root{--inst-az:#082868;--inst-az-2:#0b3488;--inst-az-osc:#051c4a;--inst-ver:#009000;--inst-ama:#f0e000;}

/* ---------- Menú lateral ---------- */
.main-sidebar.sb-inst{background:linear-gradient(180deg,var(--inst-az) 0%,var(--inst-az-osc) 100%);box-shadow:4px 0 24px -12px rgba(5,28,74,.6);}
.sb-inst .brand-link.sb-marca{display:flex;align-items:center;gap:10px;padding:12px 12px 14px;border-bottom:0;position:relative;height:auto;min-height:64px;}
.sb-inst .brand-link.sb-marca::after{content:"";position:absolute;left:0;right:0;bottom:0;height:4px;
    background:linear-gradient(90deg,var(--inst-az-2) 0 50%,var(--inst-ver) 50% 80%,var(--inst-ama) 80% 100%);}
.sb-inst .sb-logo{width:44px;height:44px;border-radius:12px;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;
    box-shadow:0 4px 12px -4px rgba(0,0,0,.4);overflow:hidden;}
.sb-inst .sb-logo img{width:40px;height:auto;}
.sb-inst .sb-logo.sb-logo-ac{background:transparent;box-shadow:0 0 0 2px rgba(255,255,255,.18);} .sb-inst .sb-logo.sb-logo-ac img{width:44px;height:44px;}
.sb-inst .sb-marca-txt{display:flex;flex-direction:column;line-height:1.15;white-space:nowrap;color:#fff;font-weight:400;}
.sb-inst .sb-marca-txt b{font-size:14.5px;font-weight:700;letter-spacing:.01em;}
.sb-inst .sb-marca-txt small{font-size:11.5px;color:#b9c8ec;}
.sb-inst .sidebar{padding:0 10px;}
.sb-inst .sidebar nav{padding-top:12px !important;}

/* Buscador del menú */
.sb-inst .form-control-sidebar,.sb-inst .btn-sidebar{background:rgba(255,255,255,.08) !important;border:1px solid rgba(255,255,255,.12) !important;color:#fff !important;}
.sb-inst .form-control-sidebar{border-radius:10px 0 0 10px;border-right:0 !important;}
.sb-inst .form-control-sidebar::placeholder{color:#9fb3df;}
.sb-inst .btn-sidebar{border-radius:0 10px 10px 0;border-left:0 !important;}
.sb-inst .sidebar-search-results .list-group-item{background:#fff;color:#1f2937;}

/* Encabezados de grupo */
.sb-inst .nav-sidebar .nav-header{color:#8ea4d6 !important;font-size:11px;font-weight:700;letter-spacing:.09em;padding:16px 12px 6px;}

/* Opciones */
.sb-inst .nav-sidebar > .nav-item{margin-bottom:2px;}
.sb-inst .nav-sidebar .nav-link{color:#dbe4f7 !important;border-radius:10px;padding:9px 12px;transition:background .15s,color .15s;}
.sb-inst .nav-sidebar .nav-link > .nav-icon,
.sb-inst .nav-sidebar .nav-link > i:first-child{color:#9fb3df;font-size:17px;width:24px;text-align:center;margin-right:8px;transition:color .15s;}
.sb-inst .nav-sidebar .nav-link p{font-size:14.5px;font-weight:500;}
.sb-inst .nav-sidebar .nav-link:hover{background:rgba(255,255,255,.08) !important;color:#fff !important;}
.sb-inst .nav-sidebar .nav-link:hover > i:first-child{color:#fff;}

/* Opción activa: pastilla blanca con acento amarillo */
.sb-inst .nav-sidebar > .nav-item > .nav-link.active{background:#fff !important;color:var(--inst-az) !important;font-weight:700;
    box-shadow:0 6px 16px -8px rgba(0,0,0,.5) !important;position:relative;}
.sb-inst .nav-sidebar > .nav-item > .nav-link.active > i:first-child{color:var(--inst-az);}
.sb-inst .nav-sidebar > .nav-item > .nav-link.active::before{content:"";position:absolute;left:-10px;top:8px;bottom:8px;width:4px;border-radius:0 4px 4px 0;background:var(--inst-ama);}
/* Grupo abierto */
.sb-inst .nav-sidebar .menu-open > .nav-link:not(.active),
.sb-inst .nav-sidebar .menu-is-opening > .nav-link:not(.active){background:rgba(255,255,255,.06) !important;color:#fff !important;}
.sb-inst .nav-sidebar .nav-link .right{color:#8ea4d6;}

/* Submenús */
.sb-inst .nav-treeview{margin:2px 0 6px 18px;padding-left:8px;border-left:1px solid rgba(255,255,255,.12);}
.sb-inst .nav-treeview .nav-link{padding:7px 10px;}
.sb-inst .nav-treeview .nav-link p{font-size:13.5px;font-weight:400;}
.sb-inst .nav-treeview .nav-link > i:first-child{font-size:15px;width:20px;margin-right:6px;}
.sb-inst .nav-treeview .nav-link.active{background:rgba(255,255,255,.14) !important;color:#fff !important;font-weight:600;}
.sb-inst .nav-treeview .nav-link.active > i:first-child{color:var(--inst-ama);}

/* Enlaces que abren otra pestaña */
.sb-inst .nav-link[target="_blank"] p::after{content:"\F1C5";font-family:"bootstrap-icons";font-size:11px;margin-left:6px;opacity:.6;}

/* Menú contraído (solo iconos) */
.sidebar-mini.sidebar-collapse .sb-inst .nav-sidebar .nav-header{display:none;}
.sidebar-mini.sidebar-collapse .main-sidebar.sb-inst:not(:hover) .brand-link.sb-marca{justify-content:center;padding:12px 6px 14px;}
.sidebar-mini.sidebar-collapse .main-sidebar.sb-inst:not(:hover) .sb-marca-txt{display:none;}
.sidebar-mini.sidebar-collapse .main-sidebar.sb-inst:not(:hover) .sidebar{padding:0 6px;}
.sidebar-mini.sidebar-collapse .main-sidebar.sb-inst:not(:hover) .nav-link.active::before{display:none;}
.sidebar-mini.sidebar-collapse .main-sidebar.sb-inst:not(:hover) .nav-treeview{margin-left:0;border-left:0;padding-left:0;}

/* ---------- Barra superior ---------- */
.main-header.nv-inst{border-bottom:1px solid #e5e7eb;box-shadow:0 1px 3px rgba(8,40,104,.05);}
.main-header.nv-inst .nav-link{color:#334155;}
.main-header.nv-inst .nav-link:hover{color:var(--inst-az);}
.content-wrapper{background:#f5f7fb;}

</style>
