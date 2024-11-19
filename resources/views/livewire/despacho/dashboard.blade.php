<div>
    <h4><span class="text-muted fw-light">Despacho /</span> Dashboard</h4>
    <div class="row">
        <div class="col-12">
            <h5>Pedidos</h5>
            <div class="card mb-4">
                <div class="card-widget-separator-wrapper">
                    <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h3 class="mb-1 text-secondary">{{ $enproceso }}</h3>
                                        <p class="mb-0">En proceso</p>
                                    </div>
                                    <span class="badge bg-label-secondary rounded p-2 me-sm-4">
                                        <i class='bx bxs-basket bx-sm'></i>
                                    </span>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none me-4">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h3 class="mb-1 text-info">{{ $solicitados }}</h3>
                                        <p class="mb-0">Solicitados</p>
                                    </div>
                                    <span class="badge bg-label-info rounded p-2 me-lg-4">
                                        <i class='bx bxs-box bx-sm'></i>
                                    </span>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                    <div>
                                        <h3 class="mb-1 text-primary">{{ $deliverys }}</h3>
                                        <p class="mb-0">Delivery</p>
                                    </div>
                                    <span class="badge bg-label-primary rounded p-2 me-sm-4">
                                        <i class='bx bxs-truck bx-sm'></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h3 class="mb-1 text-warning">{{ $devueltos }}</h3>
                                        <p class="mb-0">Devueltos</p>
                                    </div>
                                    <span class="badge bg-label-warning rounded p-2">
                                        <i class='bx bxs-left-arrow-square bx-sm'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
