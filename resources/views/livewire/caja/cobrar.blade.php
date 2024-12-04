<div>
    <h4><span class="text-muted fw-light">Caja /</span> Cobrar</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="table-responsive">
                    <table class="table table-border-bottom-0" style="font-size: 0.9em;">
                        <tr>
                            <td><small>Pedido[Ticket]</small><br><span class="text-primary">{{ $venta->id }}</span>
                                <span class="text-success">[{{ $venta->cor_ticket }}]</span>
                            </td>
                            <td>
                                <small>Pago</small><br>
                                {!! estadoPago($venta->est_pago) !!}
                            </td>
                            <td colspan="2"><small>Cliente</small><br><span
                                    class="text-info">{{ $venta->cliente->razon_social }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <small>F. Pago</small><br>{{ $venta->fpago == 1 ? 'Crédito' : 'Contado' }}
                            </td>
                            <td>
                                <small>Estado pedido</small><br>
                                {!! estadoVenta($venta->est_venta) !!}
                            </td>
                            <td>
                                <small>Fecha</small><br>{{ $venta->updated_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('caja.cajas.ver', $caja->id) }}" class="btn btn-icon btn-secondary"
                                    title="Regresar a caja"><i class="fa-solid fa-arrow-left"></i></a>

                                @if ($venta->est_pago == null || ($venta->fpago == 1 && $mcuotas == $venta->total))
                                    @if ($venta->serie == null)
                                        <button class="btn btn-icon btn-info" wire:click='emitir'><i
                                                class="fa-solid fa-receipt" title="Emitir comprobante"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-icon btn-info" wire:click='vcomprobante'><i
                                                class="fa-solid fa-receipt" title="Ver comprobante"></i>
                                        </button>
                                    @endif
                                @endif
                                @if (!$caja->cierre)
                                    @can('caja.cajas.ver.cobrar.credito')
                                        @if (!$venta->fpago && $pagos->count() == 0)
                                            <button class="btn btn-icon btn-warning" wire:click='acredito'
                                                title="Venta a crédito"><i
                                                    class="fa-solid fa-money-bill-transfer"></i></button>
                                        @elseif($mcuotas == 0 && $venta->est_pago == 1)
                                            <button class="btn btn-icon btn-info" wire:click='acredito'
                                                title="Venta al contado"><i class="fa-solid fa-money-bill"></i></button>
                                        @endif
                                    @endcan
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="table-responsive text-nowrap">
                    @if ($productos->count())
                        <table class="table table-hover table-sm" style="font-size: 0.8em;">
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
                                        <td class="text-end">{{ $producto->cantidad }}</td>
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
                            <x-msg type="info" msg="Sin productos" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-action mb-4">
                <div class="card-header align-items-center flex-wrap gap-3 py-4">
                    <h5 class="card-action-title mb-0">Pagos</h5>
                    <div class="card-action-element">
                        @if ($venta->est_pago == 1 && $venta->fpago == null)
                            @can('caja.cajas.ver.cobrar.pago')
                                <button class="btn btn-icon btn-primary btn-sm" wire:click='apagoContado()'
                                    title="Registrar pago"><i class="fa-solid fa-hand-holding-dollar"></i></button>
                            @endcan
                        @endif
                    </div>
                </div>
                @if ($pagos->count())
                    <div class="table-responsive">
                        <table class="table table-hover border-top" style="font-size: 0.8em;">
                            <thead>
                                <tr>
                                    <th>M. Pago</th>
                                    <th>Fecha</th>
                                    <th style="text-align: right;">Cuota</th>
                                    <th class="text-end">observación</th>
                                    <th class="text-end">Monto</th>
                                    @if (!$caja->cierre)
                                        <th>Eliminar</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($pagos as $pago)
                                    @php
                                        $t += $pago->monto;
                                    @endphp
                                    <tr>
                                        <td>{{ $pago->mpago->nombre }}</td>
                                        <td>{{ date('d/m/Y', strtotime($pago->created_at)) }}</td>
                                        <td style="text-align: right;">
                                            {{ $pago->cuota->numero ?? '' }}</td>
                                        <td>{{ $pago->observacion }}</td>
                                        <td class="text-end">{{ number_format($pago->monto, 2) }}
                                        </td>
                                        @if (!$caja->cierre)
                                            <td>
                                                @if ($loop->last)
                                                    <button class="btn btn-icon btn-outline-danger btn-sm"
                                                        x-data="eliminar"
                                                        x-on:click="confirmar({{ $pago->id }}, '{{ $pago->monto }}')"
                                                        title="Anular pago"><i
                                                            class="tf-icons fa-solid fa-xmark"></i></button>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="table-border-bottom-0">
                                <tr>
                                    <th colspan="4" class="fw-bold">Total</th>
                                    <th class="text-end fw-bold">{{ number_format($t, 2) }}</th>
                                    @if (!$caja->cierre)
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                @else
                    <div class="mx-3 mb-3">
                        <x-msg type="info" msg="No se encontraron pagos" />
                    </div>
                @endif
            </div>
            @if ($venta->fpago)
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center flex-wrap gap-3 py-4">
                        <h5 class="card-action-title mb-0">Cuotas</h5>
                        <div class="card-action-element">
                            @if ($mcuotas < $venta->total)
                                <button class="btn btn-icon btn-primary btn-sm" wire:click='acuota'
                                    title="Agregar cuota"><i class="fa-solid fa-plus"></i></button>
                            @endif
                        </div>
                    </div>

                    @if ($venta->cuotas->count())
                        <div class="table-responsive">
                            <table class="table table-hover border-top" style="font-size: 0.8em;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>F. Vence</th>
                                        <th class="text-end">Monto</th>
                                        <th>Estado</th>
                                        @if (!$caja->cierre)
                                            <th class="text-end">Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tc = 0;
                                        $pcc = 0;
                                    @endphp
                                    @foreach ($venta->cuotas as $cuota)
                                        @php
                                            $tc += $cuota->monto;
                                            if ($cuota->estado == 1) {
                                                $pcc += 1;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $cuota->numero }}</td>
                                            <td>{{ date('d/m/Y', strtotime($cuota->fvence)) }}</td>
                                            <td class="text-end">{{ $cuota->monto }}</td>
                                            <td>{!! estadoPago($cuota->estado) !!}</td>
                                            @if (!$caja->cierre)
                                                <td class="text-end">
                                                    @if ($pcc == 1)
                                                        <button class="btn btn-icon btn-outline-info btn-sm"
                                                            wire:click='apagoCuota({{ $cuota->id }})'
                                                            title="Cobrar cuota"><i
                                                                class="fa-solid fa-hand-holding-dollar"></i></button>
                                                    @endif
                                                    @if ($loop->last)
                                                        @if ($cuota->pagos()->count() == 0)
                                                            <button class="btn btn-icon btn-outline-danger btn-sm"
                                                                x-data="eliminarc"
                                                                x-on:click="confirmar({{ $cuota->id }}, '{{ $cuota->monto . ' del ' . date('d/m/Y', strtotime($cuota->fvence)) }}')"
                                                                title="Eliminar cuota"><i
                                                                    class="tf-icons fa-solid fa-trash"></i></button>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <thead class="table-border-bottom-0">
                                    <tr>
                                        <th colspan="3" class="fw-bold">Total cuotas</th>
                                        <th class="text-end fw-bold">{{ $tc }}</th>
                                        @if (!$caja->cierre)
                                            <th></th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="fw-bold">Total pendiente</th>
                                        <th class="text-end fw-bold">{{ $tc - $t }}</th>
                                        @if (!$caja->cierre)
                                            <th></th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @else
                        <div class="mx-3 mb-3">
                            <x-msg type="info" msg="No se encontraron cuotas" />
                        </div>
                    @endif
                </div>
            @endif
            @if ($pagosAnulados->count())
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center flex-wrap gap-3 py-4">
                        <h5 class="card-action-title mb-0">Pagos Anulados</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover border-top" style="font-size: 0.8em;">
                            <thead>
                                <tr>
                                    <th>M. Pago</th>
                                    <th>Fecha</th>
                                    <th class="text-end">observación</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pagosAnulados as $pagoAnulado)
                                    <tr>
                                        <td>{{ $pagoAnulado->mpago->nombre }}</td>
                                        <td>{{ date('d/m/Y', strtotime($pagoAnulado->created_at)) }}</td>
                                        <td>{{ $pagoAnulado->observacion }}</td>
                                        <td class="text-end">{{ number_format($pagoAnulado->monto, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-modal-form mId="mPre" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col">
                <x-label for="precio">Precio</x-label>
                <x-input type="number" id="precio" wire:model="precio" />
                <x-input-error for="precio" />
            </div>
        </div>
    </x-modal-form>
    <x-modal-form mId="mCob" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label for="mpago">Modo de pago</x-label>
                <x-select id="mpago" wire:model.live="mpago">
                    <option value="">Seleccione...</option>
                    @foreach ($mpagos as $k => $mp)
                        <option value="{{ $k }}">{{ $mp }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="mpago" />
            </div>
            <div class="col-12">
                <x-label for="monto">Monto</x-label>
                <x-input type="number" id="monto" wire:model="monto" />
                <x-input-error for="monto" />
            </div>
            @if ($mpago == 1)
                <div class="col-12">
                    <x-label for="mrecibido">Monto recibido</x-label>
                    <x-input type="number" id="mrecibido" wire:model="mrecibido" />
                    <x-input-error for="mrecibido" />
                </div>
            @endif
            <div class="col-12">
                <x-label for="observacion">Observación</x-label>
                <x-input type="text" id="observacion" wire:model="observacion" />
                <x-input-error for="observacion" />
            </div>
        </div>
    </x-modal-form>
    <x-modal-form mId="mCuota" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label for="fvence">F. Vencimiento</x-label>
                <x-input type="date" id="fvence" wire:model="fvence" />
                <x-input-error for="fvence" />
            </div>
            <div class="col-12">
                <x-label for="mcuota">Monto Cuota</x-label>
                <x-input type="number" id="mcuota" wire:model="mcuota" />
                <x-input-error for="mcuota" />
            </div>
        </div>
    </x-modal-form>
    <x-modal-form mId="mEmi" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label for="tcomprobante">Tipo comprobante</x-label>
                <x-select id="tcomprobante" wire:model.live="tcomprobante">
                    <option value="">Seleccione...</option>
                    @foreach ($tcomprobantes as $ic => $comprobante)
                        <option value="{{ $ic }}">{{ $comprobante }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="tcomprobante" />
            </div>
        </div>
    </x-modal-form>
    <x-modal-view mId="mPdf" :mTitle="$mTitle" mSize="md">

        <iframe src="{{ $rComp }}" width="100%" height="600"></iframe>

    </x-modal-view>
    @script
        <script>
            Livewire.on('smp', (e) => {
                $("#mPre").modal('show')
            });
            Livewire.on('hmp', (e) => {
                $("#mPre").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })

            Livewire.on('re', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Livewire.on('smc', (e) => {
                $("#mCob").modal('show')
            });
            Livewire.on('hmc', (e) => {
                $("#mCob").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })

            Livewire.on('smcuo', (e) => {
                $("#mCuota").modal('show')
            });
            Livewire.on('hmcuo', (e) => {
                $("#mCuota").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })

            Livewire.on('smemi', (e) => {
                $("#mEmi").modal('show')
            });
            Livewire.on('hmemi', (e) => {
                $("#mEmi").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })

            Alpine.data('eliminar', () => ({
                confirmar(id, nom) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "¡Anularás!<p><strong>Pago de " + nom + "</strong></p>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, Anúlalo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete', {
                                pago: id
                            })
                        }
                    })
                }
            }))

            Alpine.data('eliminarc', () => ({
                confirmar(id, nom) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "¡Eliminarás!<p><strong>Cuota de " + nom + "</strong></p>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deletec', {
                                cuota: id
                            })
                        }
                    })
                }
            }))

            Livewire.on('vu', (e) => {
                Swal.fire("Vuelto: " + e);
            })

            Livewire.on('vcomp', (e) => {
                $("#mPdf").modal('show')
            })
        </script>
    @endscript
</div>
