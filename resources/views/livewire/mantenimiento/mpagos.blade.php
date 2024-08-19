<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Modos de pago</h4>
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
                @can('mantenimiento.mpagos.agregar')
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
        @if ($mpagos->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        @canany(['mantenimiento.mpagos.editar', 'mantenimiento.mpagos.eliminar'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mpagos as $mpago)
                    <tr wire:key="{{ $mpago->id }}">
                        <td>{{ $mpago->id }}</td>
                        <td>{{ $mpago->nombre }}</td>
                        <td><x-status :status="$mpago->estado" /></td>
                        @canany(['mantenimiento.mpagos.editar', 'mantenimiento.mpagos.eliminar'])
                        <td>
                            @can('mantenimiento.mpagos.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $mpago->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @can('mantenimiento.mpagos.estado')
                            <button class="btn btn-icon btn-secondary btn-sm" title="Estado"
                                wire:click="status({{ $mpago->id }})"><i class="tf-icons fa-solid fa-toggle-on"></i></button>
                            @endcan
                            @can('mantenimiento.mpagos.eliminar')
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $mpago->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endcan
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $mpagos->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @canany(['mantenimiento.mpagos.agregar', 'mantenimiento.mpagos.editar'])
    <x-modal-form mId="mPer" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col">
                <x-label class="form-label" for="nombre">Nombre</x-label>
                <x-input class="form-control" type="text" id="nombre" wire:model="nombre" />
                <x-input-error for="nombre" />
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
                            mpago: id
                        })
                    }
                })
            }
        }))
    </script>
    @endscript
</div>
