<div>
    <h4><span class="text-muted fw-light">Abastecimiento /</span> Productos</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar..."
                        wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-2">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
        @if ($productos->count())
            <div class="table-responsive text-noweap">
                <table class="table table-sm table-hover text-small">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Stock Mínimo</th>
                            <th>Stock Actual</th>
                            @canany(['abastecimiento.productos.reposiciones', 'abastecimiento.productos.stock'])
                                <th>Acciones</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr wire:key="{{ $producto->id }}">
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->nombre }}</td>
                                @php
                                    $stock = $producto->stocks->where('sucursal_id', $sucursal->id)->first();
                                @endphp
                                <td>
                                    @if ($stock)
                                        {{ $stock->stock_minimo }}
                                    @endif
                                </td>
                                <td>
                                    @if ($stock)
                                        {{ $stock->stock }}
                                    @endif
                                </td>
                                @canany(['abastecimiento.productos.reposiciones', 'abastecimiento.productos.stock'])
                                    <td>
                                        @can('abastecimiento.productos.stock')
                                            <button class="btn btn-icon btn-warning btn-sm" title="Agregar stock mínimo"
                                                wire:click="stock({{ $producto->id }})">
                                                <i class="tf-icons fa-solid fa-cubes-stacked"></i>
                                            </button>
                                        @endcan
                                        @can('abastecimiento.productos.reposiciones')
                                            @if ($stock)
                                                <a href="{{ route('abastecimiento.productos.reposiciones', $producto->id) }}"
                                                    class="btn btn-icon btn-info btn-sm" title="Ir a reposiciones">
                                                    <i class="tf-icons fa-solid fa-cart-flatbed"></i>
                                                </a>
                                            @endif
                                        @endcan

                                    </td>
                                @endcanany
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
    <x-modal-form mId="mStock" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label class="form-label" for="stock_minimo">Stock Mínimo</x-label>
                <x-input class="form-control" type="number" id="stock_minimo" wire:model="stock_minimo" />
                <x-input-error for="stock_minimo" />
            </div>
        </div>
    </x-modal-form>
    @script
        <script>
            Livewire.on('sm', (e) => {
                $("#mStock").modal('show')
            });
            Livewire.on('hm', (e) => {
                $("#mStock").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('re', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Livewire.on('smv', (e) => {
                $("#mVer").modal('show')
            })
        </script>
    @endscript
</div>
