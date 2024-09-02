<div>
    <h4><span class="text-muted fw-light">Abastecimiento /</span> Dashboard <span class="text-warning">(Sucursal:
        {{$sucursal->nombre}})</span></h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Stock Mínimo</th>
                                <th>Semaforo</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock->producto->nombre }}</td>
                                <td>{{ $stock->stock }}</td>
                                <td>{{ $stock->stock_minimo }}</td>
                                <td>
                                    <i class="fa-solid fa-square {{$stock->stock < $stock->stock_minimo ? 'text-danger' : 'text-warning'}}"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
