<div>
    <div class="d-flex justify-content-between">
        <h4><span class="text-muted fw-light">Delivery /</span> Dashboard</h4>
        <h4><i class="fa-solid fa-store text-muted"></i>
            {{ $sucursal->nombre }}</h4>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md border-5 border-light-primary rounded-circle mx-auto mb-4">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class='bx bxs-truck bx-sm'></i>
                        </span>
                    </div>
                    <h3 class="card-title mb-1 me-2">{{ $paraDelivery }}</h3>
                    <small class="d-block mb-2">Pedido(s)</small>
                    <span class="text-primary">Para delivery</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md border-5 border-light-info rounded-circle mx-auto mb-4">
                        <span class="avatar-initial rounded-circle bg-label-info">
                            <i class='bx bx-package bx-sm'></i>
                        </span>
                    </div>
                    <h3 class="card-title mb-1 me-2">{{ $pedEntregadosHoy }}</h3>
                    <small class="d-block mb-2">Entregados Hoy</small>
                    <span class="text-info">{{ date('d/m/Y', strtotime(now())) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md border-5 border-light-success rounded-circle mx-auto mb-4">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class='bx bx-box bx-sm'></i>
                        </span>
                    </div>
                    <h3 class="card-title mb-1 me-2">{{ $pedEntregadosMes }}</h3>
                    <small class="d-block mb-2">Entregados Mes</small>
                    <span class="text-success">{{ date('m/Y', strtotime(now())) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md border-5 border-light-warning rounded-circle mx-auto mb-4">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class='bx bx-left-down-arrow-circle bx-sm'></i>
                        </span>
                    </div>
                    <h3 class="card-title mb-1 me-2">{{ $devueltos }}</h3>
                    <small class="d-block mb-2">Pedido(s)</small>
                    <span class="text-success">Devueltos</span>
                </div>
            </div>
        </div>
    </div>
</div>
