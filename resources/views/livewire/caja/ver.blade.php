<div>
    <h4><span class="text-muted fw-light">Caja /</span> Detalle <span class="text-warning">(Sucursal:
            {{ $sucursal->nombre }})</span></h4>
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="table-responsive">
                    <table class="table table-border-bottom-0">
                        <tr>
                            <td style="font-size: 1.2em"><small># Caja</small><br><b>{{$caja->id}}</b></td>
                            <td colspan="2"><small>Responsable</small><br><span
                                    class="text-info">{{$caja->user->name}}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <small>Estado</small><br>
                                {{($caja->cierre)?'Cerrada':'Abierta'}}
                            </td>
                            <td>
                                <small>Fecha Apertura</small> {{date('d/m/Y', strtotime($caja->apertura))}}<br>
                                @if($caja->cierre)
                                <small>Fecha Cierre</small> {{date('d/m/Y', strtotime($caja->cierre))}}<br>
                                @endif
                            </td>
                            <td class="text-end">

                                <button class="btn btn-icon btn-outline-info" title="Agregar movimiento"><i class="tf-icons fa-solid fa-arrow-right-arrow-left"></i></button>

                                @if(!$caja->cierre)
                                <button class="btn btn-icon btn-outline-danger" title="Cerrar caja"><i
                                        class="tf-icons fa-solid fa-lock"></i></button>
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header text-info">Pagos</h5>
                @if($pagos->count())
                <div class="table-responsive">
                    <table class="table table-hover">
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
                            <tr>
                                <td>{{$pago->id}}</td>
                                <td style="font-size:0.8em;">{{date('d/m/Y H:i:s', strtotime($pago->created_at))}}</td>
                                <td style="font-size:0.8em;">{{$pago->venta->cliente->razon_social}}</td>
                                <td>{{$pago->monto}}</td>
                                <td style="font-size:0.8em;">{{$pago->mpago->nombre}}</td>
                                <td>
                                    <a href="{{ route('caja.cajas.ver.cobrar', [$caja->id, $pago->venta_id]) }}"
                                        class="btn btn-icon btn-warning btn-sm" title="Ver venta"><i
                                            class="fa-solid fa-hand-holding-dollar"></i></a>
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
                $tm=0;
                @endphp
                @if($movimientos->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movimientos as $movimiento)
                            @php
                            if($movimiento->tipo==1){
                            $tm+=$movimiento->monto;
                            }else{
                            $tm-=$movimiento->monto;
                            }
                            @endphp
                            <tr>
                                <td>{{tipoMovimiento($movimiento->tipo)}}</td>
                                <td>{{$movimiento->concepto}}</td>
                                <td>{{$movimiento->monto}}</td>
                                <td>
                                    <button class="btn btn-icon btn-outline-danger btn-sm" title="Eliminar"><i
                                            class="tf-icons fa-solid fa-trash-can"></i></button>
                                </td>
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
                <div class="table-responsive text-noweap">
                    <table class="table table-sm table-hover text-small">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cliente</th>
                                <th>Fecha</th>

                                <th>Cobrar</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas as $venta)
                            <tr wire:key="{{ $venta->id }}" style="font-size: 0.8em">
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->cliente }}</td>
                                <td>{{ date('d/m/Y', strtotime($venta->created_at)) }}</td>

                                <td>
                                    <a href="{{ route('caja.cajas.ver.cobrar', [$caja->id, $venta->id]) }}"
                                        class="btn btn-icon btn-outline-success btn-sm" title="Cobrar"><i
                                            class="tf-icons fa-solid fa-money-bill-1-wave"></i></a>
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
            <div class="card mb-4">
                <h5 class="card-header text-info">Resumen pagos</h5>
                @php
                $tp=0;
                @endphp
                @if($totalPagos->count())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>M. Pago</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($totalPagos as $pago)
                            @php
                            $tp+=$pago->total;
                            @endphp
                            <tr>
                                <td>{{$pago->mpago->nombre}}</td>
                                <td class="text-end">{{$pago->total}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td><strong>Total</strong></td>
                                <td class="text-end"><strong>{{$tp}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="card mb-4">
                <h5 class="card-header text-info">Resumen caja</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>Total pagos</td>
                                <td class="text-end">{{$tp}}</td>
                            </tr>
                            <tr>
                                <td>Total movimientos</td>
                                <td class="text-end">{{$tm}}</td>
                            </tr>
                            <tr>
                                <td><strong>Total caja</strong></td>
                                <td class="text-end"><strong>{{$tp+$tm}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
