<div>
    <h4><span class="text-muted fw-light">Delivery /</span> Entregar <span class="text-info">(Sucursal:
            {{ $sucursal->nombre }})</span></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="flex mb-3">
                <a href="{{ route('delivery.misentregas') }}" class="btn btn-icon btn-secondary" title="Regresar"><i
                        class="fa-solid fa-arrow-left"></i></a>
            </div>
            <div class="card mb-4">
                <div class="table-responsive text-nowrap">
                    @if ($productos->count())
                        <table class="table table-hover" style="font-size: 0.8em;">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Cantidad</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($productos as $producto)
                                    @php
                                        $t += $producto->total;
                                    @endphp
                                    <tr>
                                        <td>{{ $producto->nombre }}</td>
                                        <td class="text-end text-danger">{{ $producto->cantidad }}</td>
                                        <td class="text-end">{{ $producto->precio }}</td>
                                        <td class="text-end">{{ number_format($producto->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="table-border-bottom-0">
                                <tr>
                                    <th colspan="3" class="fw-bold">Total</th>
                                    <th class="fw-bold text-end">{{ number_format($t, 2) }}</th>
                                </tr>
                            </thead>

                        </table>
                    @else
                        <div class="m-3">
                            <x-msg type="info" msg="Pedido sin productos" />
                        </div>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.9em;">
                        <tr>
                            <td><small>Pedido ID</small><br><span class="text-primary">{{ $venta->id }}</span></td>
                            <td><small>Pago</small><br>{!! estadoPago($venta->est_pago) !!}</td>
                            <td><small>Estado</small><br>{!! estadoVenta($venta->est_venta) !!}</td>
                        </tr>
                        <tr>
                            <td><small>F. pago</small><br>{{ $venta->fpago ? 'Crédito' : 'Contado' }}</td>
                            <td><small>T. Comprobante</small>
                                @if ($venta->tcomprobante_id)
                                    <br>{{ $venta->tcomprobante->descripcion }}
                                @endif
                            </td>
                            <td>
                                <small>N. Comprobante</small>
                                @if ($venta->tcomprobante_id)
                                    <br>{{ $venta->serie }}-{{ $venta->correlativo }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="row m-4">
                <div class="col">
                    <h6 class="mb-0 w-px-100 text-warning"><i class="bx bxs-circle fs-tiny me-2"></i>Solicitado
                        <spam class="text-muted" style="font-size: 0.7em;">
                            {{ date('d/m/y H:i:s', strtotime($venta->created_at)) }}</spam>
                    </h6>
                </div>
                @if ($venta->fdelivery)
                    <div class="col">
                        <h6 class="mb-0 w-px-100 text-primary"><i class="bx bxs-circle fs-tiny me-2"></i>Delivery
                            <spam class="text-muted" style="font-size: 0.7em;">
                                {{ date('d/m/y H:i:s', strtotime($venta->fdelivery)) }}</spam>
                    </div>
                @endif
                @if ($venta->fentrega)
                    <div class="col">
                        <h6 class="mb-0 w-px-100 text-success"><i class="bx bxs-circle fs-tiny me-2"></i>Entregado
                            <spam class="text-muted" style="font-size: 0.7em;">
                                {{ date('d/m/y H:i:s', strtotime($venta->fentrega)) }}</spam>
                    </div>
                @endif
                @if ($venta->fanulado)
                    <div class="col">
                        <h6 class="mb-0 w-px-100 text-danger"><i class="bx bxs-circle fs-tiny me-2"></i>Anulado
                            <spam class="text-muted" style="font-size: 0.7em;">
                                {{ date('d/m/y H:i:s', strtotime($venta->fanulado)) }}</spam>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table" style="font-size: 0.9em;">
                        <tr>
                            <td>
                                <small>Ciente ID</small><br>{{ $cliente->id }}

                            </td>
                            <td colspan="2"><small>Nomble/Razón social</small><br>
                                <span class="text-info">{{ $cliente->razon_social }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><small>{{ $cliente->tdocumento->abreviatura }}</small><br>{{ $cliente->ndocumento }}
                            </td>
                            <td><small>Teléfono</small><br>{{ $cliente->telefono }}</td>
                            <td><small>Correo</small><br>{{ $cliente->correo }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <small>Dirección</small><br>
                                {{ $cliente->direccion }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <small>Referencia</small><br>{{ $cliente->referencia }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            Livewire.on('sm', (e) => {
                $("#mMod").modal('show')
            });
            Livewire.on('hm', (e) => {
                $("#mMod").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('re', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Alpine.data('entregar', () => ({
                confirmar() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡Se registrará la entrega y no podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, entregar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('entregar')
                        }
                    })
                }
            }))

            Alpine.data('delivery', () => ({
                confirmar() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡Se registrará el pedido para delivery y no podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, a delivery!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delivery')
                        }
                    })
                }
            }))

            Alpine.data('anular', () => ({
                confirmar() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡Se anulará el pedido y no podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, anular!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('anular')
                        }
                    })
                }
            }))
        </script>
    @endscript
</div>
