<div>
    <h4><span class="text-muted fw-light">Despacho /</span> Pedidos <span class="text-warning">(Sucursal:
            {{ $sucursal->nombre }})</span></h4>
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
                    <button class="btn btn-primary" title="Nuevo" wire:click="create()"><i
                            class="tf-icons fa-solid fa-basket-shopping"></i></button>
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
                    @php
                    switch ($pedido->est_venta) {
                    case '1':
                    $est='Solicitado';
                    break;
                    case '2':
                    $est='Enviado';
                    break;
                    case '3':
                    $est='Entregado';
                    break;
                    default:
                    $est='';
                    break;
                    }
                    @endphp
                    <tr wire:key="{{ $pedido->id }}">
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->razon_social }}</td>
                        <td>{{ $pedido->created_at }}</td>
                        <td>{{ $est }}</td>
                        <td>
                            @can('despacho.pedidos.canasta')
                            <a href="{{route('despacho.pedidos.canasta', $pedido->id)}}"
                                class="btn btn-icon btn-info btn-sm"><i
                                    class="tf-icons fa-solid fa-basket-shopping"></i></a>
                            @endcan
                            @if($pedido->est_venta==1)
                            @can('despacho.pedidos.eliminar')
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $pedido->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endcan
                            @endif
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
            Livewire.on('re', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Alpine.data('eliminar', () => ({
                confirmar(id) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "¡No podrás revertir esto!<br><b class='text-warning'>Venta: " + id + "</b>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete', {
                                venta: id
                            })
                        }
                    })
                }
            }))
    </script>
    @endscript
</div>
