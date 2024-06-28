@if ($errors->any())
    <div {{ $attributes->merge(['class'=>'alert alert-danger d-flex', 'role'=>'alert']) }}>
        <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">
            <i class='bx bxs-error-alt fs-3'></i>
        </span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center mb-1">¡Ups! Algo salió mal.</h6>
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
    </div>
@endif
