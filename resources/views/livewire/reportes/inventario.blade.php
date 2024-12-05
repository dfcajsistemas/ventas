<div>
    <h4><span class="text-muted fw-light">Reportes /</span> Inproductorio</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3 mb-2 mb-md-0">
                    <x-select wire:model.live='sucursal'>
                        @foreach ($sucursales as $ids => $sucursal)
                            <option value="{{ $ids }}">{{ $sucursal }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-7 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar producto ..."
                        wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-4 col-md-1">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="export()"><i
                            class="tf-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="sucursal, search, perPage, export" class="mx-3">
            <i class="fa-solid fa-circle-notch fa-spin text-warning"></i> Cargando
        </div>

        @if ($productos->count())
            <div class="table-responsive text-nowrap">
                <table class="table table-sm table-hover text-small">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Sucursal</th>
                            <th>Producto</th>
                            <th>Stock Mínimo</th>
                            <th>Stock</th>
                            <th>Precio Costo</th>
                            <th>Precio 1</th>
                            <th>Precio 2</th>
                            <th>Precio 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr wire:key="{{ $producto->id }}">
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->sucursal }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->stock_minimo }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>{{ $producto->p_costo }}</td>
                                <td>{{ $producto->p_venta1 }}</td>
                                <td>{{ $producto->p_venta2 }}</td>
                                <td>{{ $producto->p_venta3 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-3">
                {{ $productos->links() }}
            </div>
        @else
            <div class="mx-3 mb-3">
                <x-msg type="info" msg="No se encontraron resultados" />
            </div>
        @endif
    </div>
</div>
