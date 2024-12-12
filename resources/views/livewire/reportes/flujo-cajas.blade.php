<div>
    <h4><span class="text-muted fw-light">Reportes /</span> Flujo de Cajas</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar responsable ..."
                        wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <x-select wire:model.live='sucursal'>
                        @foreach ($sucursales as $ids => $sucursal)
                            <option value="{{ $ids }}">{{ $sucursal }}</option>
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

        <div wire:loading wire:target="search, sucursal, desde, hasta, perPage, export" class="mx-3">
            <i class="fa-solid fa-circle-notch fa-spin text-warning"></i> Cargando
        </div>

        @if ($cajas->count())
            <div class="table-responsive text-noweap">
                <table class="table table-sm table-hover text-small">
                    <thead>
                        <tr>
                            <th># Caja</th>
                            <th>Sucursal</th>
                            <th>F. Apertura</th>
                            <th>F. Cierre</th>
                            <th>Responsable</th>
                            <th>Monto cierre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cajas as $caja)
                            <tr wire:key="{{ $caja->id }}">
                                <td>{{ $caja->id }}</td>
                                <td>{{ $caja->sucursal }}</td>
                                <td>{{ $caja->apertura }}</td>
                                <td>{{ $caja->cierre }}</td>
                                <td>{{ $caja->usuario }}</td>
                                <td>{{ $caja->monto_cierre }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-3">
                {{ $cajas->links() }}
            </div>
        @else
            <div class="mx-3 mb-3">
                <x-msg type="info" msg="No se encontraron resultados" />
            </div>
        @endif
    </div>
</div>
