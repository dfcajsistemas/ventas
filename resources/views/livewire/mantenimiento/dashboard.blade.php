<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Dashboard</h4>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body">
                            <h6 class="card-title mb-1">{{ $empresa->razon_social }}</h6>
                            <small class="d-block mb-1">{{ $empresa->nom_comercial }}</small>

                            <a href="{{ route('mantenimiento.empresas') }}" class="btn btn-sm btn-primary">Ver
                                empresa</a>
                        </div>
                    </div>
                    <div class="col-5 pt-1">
                        <img src="{{ asset('assets/img/illustrations/empresa.png') }}" class="rounded-start img-fluid"
                            alt="Empresa">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="fa-solid fa-store"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $nsucursales }}</h4>
                    </div>
                    <p class="mb-1">Sucursales activas</p>
                    <p class="mb-0">
                        <a href="{{ route('mantenimiento.sucursals') }}"
                            class="btn btn-outline-primary btn-sm">Sucursales</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="fa-solid fa-tags"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $ncategorias }}</h4>
                    </div>
                    <p class="mb-1">Categorias activas</p>
                    <p class="mb-0">
                        <a href="{{ route('mantenimiento.categorias') }}"
                            class="btn btn-outline-warning btn-sm">Categorias</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i
                                    class="fa-solid fa-boxes-packing"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $nproductos }}</h4>
                    </div>
                    <p class="mb-1">Productos activos</p>
                    <p class="mb-0">
                        <a href="{{ route('mantenimiento.productos') }}"
                            class="btn btn-outline-danger btn-sm">Productos</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-info"><i
                                    class="fa-solid fa-sack-dollar"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $nmpagos }}</h4>
                    </div>
                    <p class="mb-1">Metodos de pago activos</p>
                    <p class="mb-0">
                        <a href="{{ route('mantenimiento.mpagos') }}" class="btn btn-outline-info btn-sm">Metodos
                            Pago</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i
                                    class="fa-solid fa-user-group"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $nclientes }}</h4>
                    </div>
                    <p class="mb-1">Clientes activos</p>
                    <p class="mb-0">
                        <a href="{{ route('mantenimiento.clientes') }}"
                            class="btn btn-outline-success btn-sm">Clientes</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    @if ($cumplesMes->count())
                        <table class="table text-nowrap table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Cumpleaños</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($cumplesMes as $cumple)
                                    <tr>
                                        <td>
                                            <span class="fw-medium lh-1">{{ $cumple->razon_social }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-label-{{ date('d/m', strtotime($cumple->fnacimiento)) == date('d/m', strtotime(now())) ? 'warning' : 'secondary' }} rounded-pill badge-center p-3 me-2"><i
                                                    class='bx bxs-cake bx-xs'></i></span>
                                            {{ date('d/m', strtotime($cumple->fnacimiento)) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="mx-3 mb-3">
                            <x-msg type="info" msg="No se encontraron resultados" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
