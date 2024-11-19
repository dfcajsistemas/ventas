<div>
    <h4><span class="text-muted fw-light">Caja /</span> Dashboard</h4>
    <div class="row">
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Cajas Abiertas</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $cajasAbiertas }}</h4>
                                <small class="text-primary">(Al {{ \Carbon\Carbon::now()->format('d/m/Y') }})</small>
                            </div>
                            <small>Por rendir</small>
                            <small>{{ \Carbon\Carbon::now()->format('l') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class='bx bx-lock-open-alt bx-sm'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Cobrado Hoy</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">S/ {{ $cobradoHoy }}</h4>
                                <small class="text-info">({{ $cobradoMes ? ($cobradoHoy / $cobradoMes) * 100 : 0 }}%
                                    Mes)</small>
                            </div>
                            <small>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-info rounded p-2">
                                <i class='bx bx-money bx-sm'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Cobrado Mes</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">S/ {{ $cobradoMes }}</h4>
                                <small class="text-danger">(100% Mes)</small>
                            </div>
                            <small>{{ \Carbon\Carbon::now()->format('m/Y') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-danger rounded p-2">
                                <i class='bx bx-money-withdraw bx-sm'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">Pendidos x Cobrar</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $pedidosSinPago }}</h4>
                                <small class="text-warning">(Al {{ \Carbon\Carbon::now()->format('d/m/Y') }})</small>
                            </div>
                            <small>Pedidos</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded p-2">
                                <i class='bx bx-cart bx-sm'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
