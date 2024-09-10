<div>
    <h4><span class="text-muted fw-light">despacho /</span> pedidos</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar cliente..."
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
                @can('despacho.pedidos.canasta')
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-primary" title="Nuevo" wire:click="create()"><i class="tf-icons fa-solid fa-basket-shopping"></i></button>
                </div>
                @endcan
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="exportar()"><i
                            class="tf-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>

        @if ($pedidos->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>N° Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                    <tr wire:key="{{ $pedido->id }}">
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->cliente }}</td>
                        <td>{{ $pedido->created_at }}</td>
                        <td>{{ $pedido->est_venta }}</td>
                        <td>
                            @can('despacho.pedidos.canasta')
                            <a href="{{route('despacho.pedidos.canasta', $pedido->id)}}" class="btn btn-icon btn-info btn-sm"><i class="tf-icons fa-solid fa-basket-shopping"></i></a>
                            @endcan
                            @can('despacho.pedidos.eliminar')
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $pedido->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $pedidos->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @script
    <script>
        Livewire.on('sm', (e) => {
                $("#mPer").modal('show')
            });
            Livewire.on('hm', (e) => {
                $("#mPer").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('rd', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Alpine.data('eliminar', () => ({
                confirmar(id) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete', {
                                id: id
                            })
                        }
                    })
                }
            }))
    </script>
    @endscript
</div>
