<div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar producto..."
                        wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-4 col-md-2">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        @if ($productos->count())
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Stock | Producto</th>
                            <th>PU</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($productos as $producto)
                            <tr>
                                <td>
                                    <small class="text-warning">{{ $producto->stock }}</small> | {{ $producto->nombre }}
                                </td>
                                <td class="text-info">{{ $producto->p_venta }}</td>
                                <td>
                                    <button class="btn btn-icon btn-success btn-sm"
                                        wire:click='add({{ $producto->id }})' title="Agregar producto"><i
                                            class="tf-icons fa-solid fa-plus"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-3">
                    {{ $productos->links() }}
                </div>
            </div>
        @else
            <div class="m-3">
                <x-msg type="info" msg="No se encontraron resultados" />
            </div>
        @endif
    </div>
    @script
        <script>
            Livewire.on('rep', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })
        </script>
    @endscript
</div>
