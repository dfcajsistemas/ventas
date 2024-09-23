<div>
    <h4><span class="text-muted fw-light">Cajas / Caja {{$caja->id}} </span> /Cobrar
        <span class="text-warning">(Sucursal:
            {{ $sucursal->nombre }})</span>
    </h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="table-responsive">
                    <table class="table table-border-bottom-0">
                        <tr>
                            <td class="text-center"><small># Venta</small><br><b>{{$venta->id}}</b></td>
                            <td>
                                <small>Pago</small><br><span
                                    class="text-danger">{{($venta->est_pago==1)?'Pendiente':'Pagado'}}</span>
                            </td>
                            <td colspan="2"><small>Cliente</small><br><span
                                    class="text-info">{{$venta->cliente->razon_social}}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <small>F. Pago</small><br>{{($venta->fpago==1)?'Crédito':'Contado'}}
                            </td>
                            <td>
                                <small>Estado</small><br>
                                {{estadoVenta($venta->est_venta)}}
                            </td>
                            <td>
                                <small>Fecha</small><br>{{date('d/m/Y', strtotime($venta->created_at))}}
                            </td>
                            <td class="text-end">
                                <a href="{{route('caja.cajas.ver', $caja->id)}}"
                                    class="btn btn-icon btn-outline-secondary" title="Regresar a caja"><i
                                        class="fa-solid fa-arrow-left"></i></a>
                                @if ($venta->est_pago==1)
                                <button class="btn btn-icon btn-success" wire:click='ncobrar' title="Cobrar">
                                    <i class="fa-solid fa-sack-dollar"></i>
                                </button>
                                @endif
                                @if($venta->est_pago==null || $venta->fpago==1)
                                <button class="btn btn-icon btn-info" wire:click='emitir'><i class="fa-solid fa-receipt"
                                        title="Emitir comprobante"></i>
                                </button>
                                @endif
                                @if($venta->pagos()->count()==0)
                                @if ($venta->est_pago==1)
                                @if($venta->fpago==null)
                                <button class="btn btn-icon btn-warning" wire:click='acredito'
                                    title="Venta al  crédito"><i class="fa-solid fa-money-bills"></i></button>
                                @endif
                                @endif
                                @if($venta->fpago==1)
                                <button class="btn btn-icon btn-warning" wire:click='acontado' title="Venta al contado"><i
                                        class="fa-solid fa-money-bills"></i>
                                </button>
                                @endif
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="table-responsive text-nowrap">
                    @if($productos->count())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-end">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Total</th>
                                @can('caja.cajas.ver.cobrar.precio')
                                <th class="text-end">C. Precio</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                            $t=0;
                            @endphp
                            @foreach ($productos as $producto)
                            @php
                            $t+=$producto->total;
                            @endphp
                            <tr>
                                <td>{{$producto->nombre}}</td>
                                <td class="text-end">{{$producto->cantidad}}</td>
                                <td class="text-end">{{$producto->precio}}</td>
                                <td class="text-end">{{ number_format($producto->total, 2) }}</td>
                                @can('caja.cajas.ver.cobrar.precio')
                                <td class="text-end">
                                    <button class="btn btn-icon btn-outline-info btn-sm"
                                        wire:click='eprecio({{$producto->id}})' title="Cambiar precio"><i
                                            class="tf-icons fa-solid fa-dollar-sign"></i></button>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                            <tr class="table-secondary text-lg">
                                <td colspan="3">Total</td>
                                <td class="text-end">{{number_format($t, 2)}}</td>
                                @can('caja.cajas.ver.cobrar.precio')
                                <td></td>
                                @endcan
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <div class="m-3">
                        <x-msg type="info" msg="Canasta vacia" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="card mb-4">
                <h5 class="card-header">Pagos</h5>
                @if($pagos->count())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>M. Pago</th>
                                <th>Fecha</th>
                                <th class="text-end">observación</th>
                                <th class="text-end">Monto</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                            $t=0;
                            @endphp
                            @foreach ($pagos as $pago)
                            @php
                            $t+=$pago->monto;
                            @endphp
                            <tr>
                                <td>{{$pago->mpago->nombre}}</td>
                                <td>{{date('d/m/Y', strtotime($pago->created_at))}}</td>
                                <td>{{$pago->observacion}}</td>
                                <td class="text-end">{{number_format($pago->monto, 2)}}</td>
                                <td>
                                    <button class="btn btn-icon btn-outline-danger btn-sm" x-data="eliminar"
                                        x-on:click="confirmar({{$pago->id}}, '{{$pago->monto}}')"
                                        title="Eliminar pago"><i class="tf-icons fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="table-secondary text-lg">
                                <td colspan="3">Total</td>
                                <td class="text-end">{{number_format($t, 2)}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="m-3">
                    <x-msg type="info" msg="No se encontraron pagos" />
                </div>
                @endif
            </div>
            @if($venta->fpago==1)
            <div class="card mb-4">
                <h5 class="card-header">Cuotas</h5>
                <div class="table-responsive">
                    <table class="table table-hover border-top">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>F. Vence</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($venta->cuotas as $cuota)
                            <tr>
                                <td>{{$cuota->numero}}</td>
                                <td>{{date('d/m/Y', strtotime($cuota->fvence))}}</td>
                                <td class="text-end">{{$cuota->monto}}</td>
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
                <x-label for="monto">Monto</x-label>
                <x-input type="number" id="monto" wire:model="monto" />
                <x-input-error for="monto" />
            </div>
            <div class="col-12">
                <x-label for="mpago">Modo de pago</x-label>
                <x-select id="mpago" wire:model.live="mpago">
                    <option value="">Seleccione...</option>
                    @foreach ($mpagos as $k=>$mp)
                    <option value="{{$k}}">{{$mp}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="mpago" />
            </div>
            @if($mpago==1)
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
    <x-modal-form mId="mCre" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label for="cuotas"># Cuotas</x-label>
                <x-input type="number" id="cuotas" wire:model="cuotas" />
                <x-input-error for="cuotas" />
            </div>
        </div>
    </x-modal-form>
    <x-modal-form mId="mEmi" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label for="tcomprobante">Tipo comprobante</x-label>
                <x-select id="tcomprobante" wire:model.live="tcomprobante">
                    <option value="">Seleccione...</option>
                    @foreach ($tcomprobantes as $ic=>$comprobante)
                    <option value="{{$ic}}">{{$comprobante}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="tcomprobante" />
            </div>
        </div>
    </x-modal-form>
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

        Livewire.on('smcre', (e) => {
            $("#mCre").modal('show')
        });
        Livewire.on('hmcre', (e) => {
            $("#mCre").modal('hide')
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
                    html: "¡Eliminarás!<p><strong>Pago de " + nom + "</strong></p>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', {
                            pago: id
                        })
                    }
                })
            }
        }))
    </script>
    @endscript
</div>
