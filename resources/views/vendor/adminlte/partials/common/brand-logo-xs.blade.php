@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

{{-- Marca: logotipo de Atención Ciudadana + nombre en dos líneas --}}
<a href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand {{ config('adminlte.classes_brand') }}"
    @else
        class="brand-link sb-marca {{ config('adminlte.classes_brand') }}"
    @endif>
    <span class="sb-logo sb-logo-ac">
        <img src="{{ asset(config('adminlte.logo_img')) }}" alt="{{ config('adminlte.logo_img_alt') }}">
    </span>
    <span class="brand-text sb-marca-txt">
        <b>Atención Ciudadana</b>
        <small>Reporta · Sigue · Resuelve</small>
    </span>
</a>
