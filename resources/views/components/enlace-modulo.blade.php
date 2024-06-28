<div class="col-md-4">
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-4">
                <img src="{{ asset($imagen) }}" alt="Accesos" class="card-img card-img-left">
            </div>
            <div class="col-8">
                <div class="card-body">
                    <small class="text-muted">Módulo</small>
                    <h6 class="card-title m-0 text-info">{{ $mod }}</h6>
                    @if($ruta)
                    <a href="{{ route($ruta)}}" class="text-success"><i class="fa-solid fa-circle-chevron-right"></i> Ir</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
