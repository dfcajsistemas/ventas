<x-app-layout modulo="Espacio" pagina="Mis módulos">
    <div class="row">
        <div class="col-md-4 px-5 align-content-center">
            <h5>Bienvenid@ 👋🏻</h5>
            <h3 class="text-info"><i class="fa-solid fa-user-tie text-muted"></i> {{ Auth()->user()->name }}</h3>
            <p>Tienes acceso a los siguientes módulos.</p>
        </div>
        @can('accesos')
        <x-enlace-modulo imagen="assets/img/modulos/accesos.jpg" mod="Accesos" ruta="accesos" />
        @endcan

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ asset('assets/img/modulos/mantenimiento.png') }}" alt="Personal"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Mantenimiento</h6>
                            <a href="#" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i>
                                Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ asset('assets/img/modulos/despacho.png') }}" alt="Despacho"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Despacho</h6>
                            <a href="#" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i>
                                Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ asset('assets/img/modulos/caja.png') }}" alt="Caja" class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Caja</h6>
                            <a href="#" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i>
                                Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ asset('assets/img/modulos/delivery.png') }}" alt="Delivery"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Delivery</h6>
                            <a href="#" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i>
                                Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ asset('assets/img/modulos/reportes.png') }}" alt="Reportes"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Reportes</h6>
                            <a href="#" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i>
                                Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
