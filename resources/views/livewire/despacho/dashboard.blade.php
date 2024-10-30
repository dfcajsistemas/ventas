<div>
    <div class="d-flex justify-content-between">
        <h4><span class="text-muted fw-light">Despacho /</span> Dashboard</h4>
        <h4><i class="fa-solid fa-store text-muted"></i>
            {{ $sucursal->nombre }}</h4>
    </div>
    <div class="row">
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">

                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="cardOpt6" style="">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <span class="d-block">Sales</span>
                    <h4 class="card-title mb-1">$4,679</h4>
                    <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                </div>
            </div>
        </div>
    </div>
</div>
