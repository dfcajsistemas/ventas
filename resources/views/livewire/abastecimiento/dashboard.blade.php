<div>
    <h4><span class="text-muted fw-light">Abastecimiento /</span> Dashboard</h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($stocks->count())
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock Actual</th>
                                    <th>Stock Mínimo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2 text-muted">
                                                    <i class="bx bxs-truck"></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">{{ $stock->producto->nombre }}</h6>
                                            </div>
                                        </td>
                                        <td
                                            class="text-{{ $stock->stock <= $stock->stock_minimo ? 'danger' : 'warning' }}">
                                            {{ $stock->stock }}</td>
                                        <td>{{ $stock->stock_minimo }}</td>
                                        <td>
                                            <span
                                                class="badge bg-label-{{ $stock->stock <= $stock->stock_minimo ? 'danger' : 'warning' }} rounded-pill badge-center p-3 me-2"><i
                                                    class='bx bxs-circle bx-xs'></i></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="m-3">
                        <x-msg type="success" msg="sucursal surtida o sin registrar un número mínimo de productos." />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
