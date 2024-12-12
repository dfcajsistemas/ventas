<div>
    <h4><span class="text-muted fw-light">Caja /</span> Detalle</h4>
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="table-responsive">
                    <table class="table table-border-bottom-0">
                        <tr>
                            <td style="font-size: 1.2em"><small># Caja</small><br><b>{{ $caja->id }}</b></td>
                            <td colspan="2"><small>Responsable</small><br><span
                                    class="text-info">{{ $caja->user->name }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <small>Estado</small><br>
                                {{ $caja->cierre ? 'Cerrada' : 'Abierta' }}
                            </td>
                            <td>
                                <small>Fecha Apertura</small> {{ date('d/m/Y', strtotime($caja->apertura)) }}<br>
                                @if ($caja->cierre)
                                    <small>Fecha Cierre</small> {{ date('d/m/Y', strtotime($caja->cierre)) }}<br>
                                @endif
                            </td>
                            <td class="text-end">
                                @if (!$caja->cierre)
                                    @can('caja.cajas.ver.movimiento')
                                        @if ($caja->user_id == auth()->user()->id)
                                            <button class="btn btn-icon btn-outline-info" title="Agregar movimiento"
                                                wire:click='amovimiento'><i
                                                    class="tf-icons fa-solid fa-arrow-right-arrow-left"></i></button>
                                        @endif
                                    @endcan
                                @endif
                                @if (!$caja->cierre)
                                    @can('caja.cajas.ver.cerrar')
                                        @if ($caja->user_id == auth()->user()->id)
                                            <button x-data="cerrar" x-on:click='confirmar()'
                                                class="btn btn-icon btn-outline-danger" title="Cerrar caja"><i
                                                    class="tf-icons fa-solid fa-lock"></i></button>
                                        @endif
                                    @endcan
                                @endif

                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header text-info">Pagos</h5>
                @if ($pagos->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>M. Pago</th>
                                    <th>Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pagos as $pago)
                                    <tr class="{{ $pago->estado == 1 ? 'table-danger' : '' }}">
                                        <td>{{ $pago->id }}</td>
                                        <td style="font-size:0.8em;">
                                            {{ date('d/m/Y H:i:s', strtotime($pago->created_at)) }}</td>
                                        <td style="font-size:0.8em;">{{ $pago->venta->cliente->razon_social }}</td>
                                        <td>{{ $pago->monto }}</td>
                                        <td style="font-size:0.8em;">{{ $pago->mpago->nombre }}</td>
                                        <td>
                                            <a href="{{ route('caja.cajas.ver.cobrar', [$caja->id, $pago->venta_id]) }}"
                                                class="btn btn-icon btn-outline-warning btn-sm" title="Ver pago"><i
                                                    class="tf-icons fa-regular fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 mx-3">
                        {{ $pagos->links() }}
                    </div>
                @else
                    <div class="mx-3 mb-3">
                        <x-msg type="info" msg="No se encontraron pagos" />
                    </div>
                @endif
            </div>
            <div class="card mb-4">
                <h5 class="card-header text-info">Movimientos</h5>
                @php
                    $tm = 0;
                @endphp
                @if ($movimientos->count())
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    @if ($caja->user_id == auth()->user()->id && !$caja->cierre)
                                        <th>Eliminar</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movimientos as $movimiento)
                                    @php
                                        if ($movimiento->tipo == 1) {
                                            $tm += $movimiento->monto;
                                        } else {
                                            $tm -= $movimiento->monto;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ tipoMovimiento($movimiento->tipo) }}</td>
                                        <td>{{ $movimiento->concepto }}</td>
                                        <td>{{ $movimiento->monto }}</td>
                                        @if ($caja->user_id == auth()->user()->id && !$caja->cierre)
                                            <td>
                                                <button x-data="eliminar"
                                                    class="btn btn-icon btn-outline-danger btn-sm" title="Eliminar"
                                                    x-on:click='confirmar({{ $movimiento->id }}, "{{ $movimiento->concepto }}")'><i
                                                        class="tf-icons fa-solid fa-trash-can"></i></button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 mx-3">
                        {{ $movimientos->links() }}
                    </div>
                @else
                    <div class="mx-3 mb-3">
                        <x-msg type="info" msg="No se encontraron movimientos" />
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-5">
            @can('caja.cajas.ver.cobrar')
                @if (!$caja->cierre)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10 mb-2 mb-md-0">
                                    <input type="search" class="form-control" placeholder="Buscar por cliente..."
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
                        @if ($ventas->count())
                            <div class="table-responsive text-nowrap">
                                <table class="table table-sm table-hover text-small">
                                    <thead>
                                        <tr>
                                            <th>#P</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ventas as $venta)
                                            <tr wire:key="{{ $venta->id }}" style="font-size: 0.8em">
                                                <td>{{ $venta->id }}</td>
                                                <td>{{ $venta->cliente }}</td>
                                                <td>{{ date('d/m/Y', strtotime($venta->created_at)) }}</td>
                                                @if ($caja->user_id == auth()->user()->id)
                                                    <td>
                                                        <a href="{{ route('caja.cajas.ver.cobrar', [$caja->id, $venta->id]) }}"
                                                            class="btn btn-icon btn-success btn-sm" title="Cobrar pedido"><i
                                                                class="tf-icons fa-solid fa-money-bill-1-wave"></i></a>
                                                    </td>
                                                @endif
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
                @endif
            @endcan
            <div class="card mb-4">
                <h5 class="card-header text-info">Resumen pagos</h5>
                @php
                    $tp = 0;
                @endphp
                @if ($totalPagos->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>M. Pago</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($totalPagos as $pago)
                                    @php
                                        $tp += $pago->total;
                                    @endphp
                                    <tr>
                                        <td>{{ $pago->mpago->nombre }}</td>
                                        <td class="text-end">{{ $pago->total }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td class="text-end"><strong>{{ $tp }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="card mb-4">
                <h5 class="card-header text-info">Resumen caja</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>Total pagos</td>
                                <td class="text-end">{{ $tp }}</td>
                            </tr>
                            <tr>
                                <td>Total movimientos</td>
                                <td class="text-end">{{ $tm }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total caja</strong></td>
                                <td class="text-end"><strong>{{ $tp + $tm }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('caja.cajas.ver.movimiento')
        <x-modal-form mId="mModelo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="md">
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-label for="tipo">Tipo</x-label>
                    <x-select class="form-select" id="tipo" wire:model="tipo">
                        <option value="">Seleccione...</option>
                        @foreach (tipoMovimiento() as $tk => $tm)
                            <option value="{{ $tk }}">{{ $tm }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="tipo" />
                </div>
                <div class="col-12 col-md-6">
                    <x-label for="monto">Monto</x-label>
                    <x-input type="number" id="monto" wire:model="monto" />
                    <x-input-error for="monto" />
                </div>
                <div class="col-12">
                    <x-label for="concepto">Concepto</x-label>
                    <x-input type="text" id="concepto" wire:model="concepto" />
                    <x-input-error for="concepto" />
                </div>
            </div>
        </x-modal-form>
    @endcan
    @script
        <script>
            Livewire.on('sm', (e) => {
                $("#mModelo").modal('show')
            });
            Livewire.on('hm', (e) => {
                $("#mModelo").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('re', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Alpine.data('eliminar', () => ({
                confirmar(id, con) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "¡Eliminarás el movimiento!<br><b>" + con +
                            "</b><br>¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete', {
                                movimiento: id
                            })
                        }
                    })
                }
            }))
            Alpine.data('cerrar', () => ({
                confirmar() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "Cerrarás la caja<br>¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, ciérralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('cerrar')
                        }
                    })
                }
            }))
        </script>
    @endscript
</div>
