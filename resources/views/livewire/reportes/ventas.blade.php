<div>
    <h4><span class="text-muted fw-light">Reportes /</span> Ventas</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3 mb-2 mb-md-0">
                    <x-select wire:model.live='estado'>
                        <option value="">Todos</option>
                        @foreach (estadoVenta() as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-3">
                    <x-input type="date" wire:model.live='desde' />
                </div>
                <div class="col-md-3">
                    <x-input type="date" wire:model.live='hasta' />
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
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="exportar()"><i
                            class="tf-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>
        @if ($ventas->count())
            <div class="table-responsive text-noweap">
                <table class="table table-sm table-hover text-small">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>F. pago</th>
                            <th>Pago</th>
                            <th>Estado</th>
                            <th>Monto</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr wire:key="{{ $venta->id }}">
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->created_at }}</td>
                                <td>{{ $venta->cliente->razon_social }}</td>
                                <td>{{ $venta->fpago == null ? 'Contado' : 'Crédito' }}</td>
                                <td>{!! estadoPago($venta->est_pago) !!}</td>
                                <td>{!! estadoVenta($venta->est_venta) !!}</td>
                                <td>{{ $venta->total }}</td>
                                <td>
                                    <button class="btn btn-icon btn-info btn-sm" title="Detalle venta"
                                        wire:click="detalle({{ $venta->id }})"><i
                                            class="tf-icons fa-solid fa-list"></i></button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-3">
                {{ $ventas->links() }}
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
