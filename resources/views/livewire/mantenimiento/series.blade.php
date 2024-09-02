<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Series</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar..."
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
                @can('mantenimiento.series.agregar')
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-primary" title="Nuevo" wire:click="create()"><i
                            class="tf-icons fa-solid fa-plus"></i></button>
                </div>
                @endcan
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="exportar()"><i
                            class="tf-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>
        @if ($series->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Serie</th>
                        <th>T. Comprobante</th>
                        <th>Sucursal</th>
                        <th>Correlativo</th>
                        <th>Estado</th>
                        @canany(['mantenimiento.series.editar', 'mantenimiento.series.eliminar'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($series as $serie)
                    <tr wire:key="{{ $serie->id }}">
                        <td>{{ $serie->id }}</td>
                        <td>{{$serie->serie}}</td>
                        <td>{{ $serie->tcomprobante->descripcion }}</td>
                        <td>{{ $serie->sucursal->nombre}}</td>
                        <td>{{$serie->correlativo}}</td>
                        <td>
                            <x-status :status="$serie->estado" />
                        </td>
                        @canany(['mantenimiento.series.editar', 'mantenimiento.series.estado', 'mantenimiento.series.eliminar'])
                        <td>
                            @if($serie->correlativo == 0)
                            @can('mantenimiento.series.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $serie->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @endif
                            @can('mantenimiento.series.estado')
                            <button class="btn btn-icon btn-secondary btn-sm" title="Estado"
                                wire:click="status({{ $serie->id }})"><i
                                    class="tf-icons fa-solid fa-toggle-on"></i></button>
                            @endcan
                            @if($serie->correlativo == 0)
                            @can('mantenimiento.series.eliminar')
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $serie->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endcan
                            @endif
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $series->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @canany(['mantenimiento.series.agregar', 'mantenimiento.series.editar'])
    <x-modal-form mId="mPer" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label class="form-label" for="tcomprobante_id">T. Comprobante</x-label>
                <x-select id="tcomprobante_id" wire:model.live="tcomprobante_id">
                    <option value="">Seleccione...</option>
                    @foreach ($tcomprobantes as $id => $tcomprobante)
                    <option value="{{ $id }}">{{ $tcomprobante }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="tcomprobante_id" />
            </div>
            <div class="col-12">
                <x-label class="form-label" for="sucursal_id">Sucursal</x-label>
                <x-select id="sucursal_id" wire:model="sucursal_id">
                    <option value="">Seleccione...</option>
                    @foreach ($sucursals as $id => $sucursal)
                    <option value="{{ $id }}">{{ $sucursal }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="sucursal_id" />
            </div>
            <div class="col-3">
                <x-label class="form-label" for="prefijo">Prefijo</x-label>
                <x-input class="form-control" type="text" id="prefijo" wire:model="prefijo" readonly />
            </div>
            <div class="col-9">
                <x-label class="form-label" for="serie">Serie</x-label>
                <x-input class="form-control" type="text" id="serie" wire:model="serie" />
                <x-input-error for="serie" />
            </div>
        </div>
    </x-modal-form>
    @endcanany
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
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', {
                            serie: id
                        })
                    }
                })
            }
        }))
    </script>
    @endscript
</div>
