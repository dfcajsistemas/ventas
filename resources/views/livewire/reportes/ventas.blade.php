<div>
    <h4><span class="text-muted fw-light">Reportes /</span> Ventas</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3 mb-2 mb-md-0">
                    <x-select wire:model.live='sucursal'>
                        @foreach ($sucursales as $ids => $sucursal)
                            <option value="{{ $ids }}">{{ $sucursal }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <x-select wire:model.live='estado'>
                        <option value="">Todos</option>
                        @foreach (estadoVenta() as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-2">
                    <x-input type="date" wire:model.live='desde' />
                </div>
                <div class="col-md-2">
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
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="export()"><i
                            class="tf-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="sucursal, estado, desde, hasta, perPage, export" class="mx-3">
            <i class="fa-solid fa-circle-notch fa-spin text-warning"></i> Cargando
        </div>

        @if ($ventas->count())
            <div class="table-responsive text-noweap">
                <table class="table table-sm table-hover text-small">
                    <thead>
                        <tr>
                            <th># Ped</th>
                            <th>Fecha</th>
                            <th>Sucursal</th>
                            <th>Cliente</th>
                            <th>F. pago</th>
                            <th>Pago</th>
                            <th>Estado</th>
                            <th>Monto</th>
                            @can('reportes.detalleventa')
                                <th>Detalle</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr wire:key="{{ $venta->id }}">
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                                <td>{{ $venta->sucursal->nombre }}</td>
                                <td>{{ $venta->cliente->razon_social }}</td>
                                <td>{{ $venta->fpago == null ? 'Contado' : 'Crédito' }}</td>
                                <td>{!! estadoPago($venta->est_pago) !!}</td>
                                <td>{!! estadoVenta($venta->est_venta) !!}</td>
                                <td>{{ $venta->total }}</td>
                                @can('reportes.detalleventa')
                                    <td>
                                        <a href="{{ route('reportes.detalleventa', $venta->id) }}" target="_blank"
                                            class="btn btn-icon btn-info btn-sm"><i class='tf-icons bx bxs-detail'></i></a>
                                    </td>
                                @endcan
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
</div>
