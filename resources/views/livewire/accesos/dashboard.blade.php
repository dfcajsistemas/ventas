<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Dashboard</h4>
    <div class="card bg-transparent shadow-none border-0 my-4">
        <div class="card-body row p-0 pb-3">
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $tusers }}</h4>
                        </div>
                        <p class="mb-1">Usuarios activos</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $troles }}</h4>
                        </div>
                        <p class="mb-1">Roles en total</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                            <h4 class="ms-1 mb-0">{{ $tpermisos }}</h4>
                        </div>
                        <p class="mb-1">Permisos en total</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
