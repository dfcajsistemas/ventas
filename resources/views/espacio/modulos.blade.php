<x-app-layout modulo="Espacio" pagina="Mis módulos">
    <h4>Mis módulos</h4>
    <div class="row">
        @can('accesos')
        <x-enlace-modulo imagen="assets/img/modulos/accesos.jpg" mod="Accesos" ruta="accesos" />
        @endcan

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ asset('assets/img/modulos/personal.jpg') }}" alt="Personal"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Personal</h6>
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
                        <img src="{{ asset('assets/img/modulos/legajo.jpg') }}" alt="Personal"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Legajo</h6>
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
                        <img src="{{ asset('assets/img/modulos/vacaciones.jpg') }}" alt="Vacaciones"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Vacaciones</h6>
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
                        <img src="{{ asset('assets/img/modulos/licencias.jpg') }}" alt="Licencias"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Licencias</h6>
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
                        <img src="{{ asset('assets/img/modulos/logistica.jpg') }}" alt="Lógistica"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Lógistica</h6>
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
                        <img src="{{ asset('assets/img/modulos/bincautados.jpg') }}" alt="B. Incautados"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">B. Incautados</h6>
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
                        <img src="{{ asset('assets/img/modulos/informatica.jpg') }}" alt="B. Incautados"
                            class="card-img card-img-left">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <small class="text-muted">Módulo</small>
                            <h6 class="card-title m-0 text-info">Informática</h6>
                            <a href="#" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i>
                                Ir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
