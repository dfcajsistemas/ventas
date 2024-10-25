<div>
    <div class="d-flex justify-content-between">
        <h4><span class="text-muted fw-light">Delivery /</span> Entregar</h4>
        <h4><span class="text-info"><i class="fa-solid fa-store text-muted"></i>
                {{ $sucursal->nombre }}</span></h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="flex mb-3">
                <a href="{{ route('delivery.pedidos') }}" class="btn btn-icon btn-secondary" title="Regresar"><i
                        class="fa-solid fa-arrow-left"></i></a>
                @if ($venta->est_venta == 2)
                    <button x-data="entregar" x-on:click="confirmar" class="btn btn-icon btn-success"
                        title="Entregar pedido"><i class="tf-icons fa-solid fa-people-carry-box"></i></button>
                    <button x-data="devolver" x-on:click="confirmar" class="btn btn-icon btn-warning"
                        title="Devolver pedido"><i class="tf-icons fa-solid fa-rotate-left"></i></button>
                @endif
            </div>
            <div class="card mb-4">
                <div class="table-responsive text-wrap">
                    @if ($productos->count())
                        <table class="table table-sm table-hover" style="font-size: 0.9em;">
                            <thead>
                                <tr>
                                    <th># Producto</th>
                                    <th class="text-end">Cant</th>
                                    <th class="text-end">PU</th>
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
                                        <td><span class="fw-bold">{{ $loop->iteration }}</span>
                                            {{ $producto->nombre }}</td>
                                        <td class="text-end text-warning">{{ $producto->cantidad }}</td>
                                        <td class="text-end">{{ $producto->precio }}</td>
                                        <td class="text-end">{{ number_format($producto->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="table-border-bottom-0">
                                <tr>
                                    <th colspan="3" class="fw-bold text-danger">Total</th>
                                    <th class="fw-bold text-end text-danger">{{ number_format($t, 2) }}</th>
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
                            <td><small>Pedido[Ticket]</small><br><span
                                    class="text-primary">{{ $venta->id }}</span><span class="text-danger">
                                    [{{ $venta->ser_ticket . '-' . $venta->cor_ticket }}]</span>
                            </td>
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
                @foreach ($eventas as $eventa)
                    <div class="col">
                        {!! estadoVenta($eventa->est_venta) !!}
                        <span style="font-size: 0.7em">{{ date('d/m/y H:i:s', strtotime($eventa->created_at)) }}</span>
                    </div>
                @endforeach
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

            Alpine.data('devolver', () => ({
                confirmar() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡Se registrará la devolución y no podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, devolver!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('devolver')
                        }
                    })
                }
            }))
        </script>
    @endscript
</div>
