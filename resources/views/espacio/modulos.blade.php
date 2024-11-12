<x-app-layout modulo="Espacio" pagina="Mis módulos">
    <div class="d-flex justify-content-between">
        <h4><span class="text-muted fw-light">Mi espacio /</span> Módulos</h4>
        <h4><i class="fa-solid fa-store text-muted"></i>
            {{ $sucursal->nombre }}</h4>
    </div>
    <div class="row">
        @can('accesos')
            <x-enlace-modulo imagen="assets/img/modulos/accesos.jpg" mod="Accesos" ruta="accesos" />
        @endcan

        @can('mantenimiento')
            <x-enlace-modulo imagen="assets/img/modulos/mantenimiento.png" mod="Mantenimiento" ruta="mantenimiento" />
        @endcan

        @can('abastecimiento')
            <x-enlace-modulo imagen="assets/img/modulos/abastecimiento.png" mod="Abastecimiento" ruta="abastecimiento" />
        @endcan

        @can('despacho')
            <x-enlace-modulo imagen="assets/img/modulos/despacho.png" mod="Despacho" ruta="despacho" />
        @endcan

        @can('caja')
            <x-enlace-modulo imagen="assets/img/modulos/caja.png" mod="Caja" ruta="caja" />
        @endcan

        @can('delivery')
            <x-enlace-modulo imagen="assets/img/modulos/delivery.png" mod="Delivery" ruta="delivery" />
        @endcan

        @can('reportes')
            <x-enlace-modulo imagen="assets/img/modulos/reportes.png" mod="Reportes" ruta="reportes.ventas" />
        @endcan
    </div>
</x-app-layout>
