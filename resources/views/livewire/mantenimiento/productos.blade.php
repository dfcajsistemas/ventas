<div>
    <h4><span class="text-muted fw-light">Mantenminto /</span> Prooductos</h4>
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
                @can('mantenimiento.productos.agregar')
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
        @if ($productos->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Estado</th>
                        @canany(['mantenimiento.productos.editar', 'mantenimiento.productos.eliminar'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr wire:key="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td><x-status :status="$producto->estado" /></td>
                        @canany(['mantenimiento.productos.editar', 'mantenimiento.productos.eliminar'])
                        <td>
                            @can('mantenimiento.productos.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $producto->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @can('mantenimiento.productos.eliminar')
                            @if ($producto->roles()->count() == 0)
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $producto->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endif
                            @endcan
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $productos->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @canany(['mantenimiento.productos.agregar', 'mantenimiento.productos.editar'])
    <x-modal-form mId="mPer" :mTitle="$mTitle" :mMethod="$mMethod" mSize="md">
        <div class="row">
            <div class="col-12">
                <x-label for="nombre">Nombre</x-label>
                <x-input type="text" id="nombre" wire:model="nombre" />
                <x-input-error for="nombre" />
            </div>
            <div class="col-12">
                <x-label for="descripcion">Descripción</x-label>
                <x-input type="text" id="descripcion" wire:model="descripcion" />
                <x-input-error for="descripcion" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="codigo">Código</x-label>
                <x-input type="text" id="codigo" wire:model="codigo" />
                <x-input-error for="codigo" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="categoria_id">Categoria</x-label>
                <x-select id="categoria_id" wire:model="categoria_id">
                    <option value="">Seleccione...</option>
                    @foreach ($categorias as $id => $categoria)
                    <option value="{{ $id }}">{{ $categoria}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="categoria_id" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="umedida_id">U. Medida</x-label>
                <x-select id="umedida_id" wire:model="umedida_id">
                    <option value="">Seleccione...</option>
                    @foreach ($umedidas as $id => $umedida)
                    <option value="{{ $id }}">{{ $umedida}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="umedida_id" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="igvafectacion_id">IGV Afectación</x-label>
                <x-select id="igvafectacion_id" wire:model="igvafectacion_id">
                    <option value="">Seleccione...</option>
                    @foreach ($igvafectacions as $id => $igvafectacion)
                    <option value="{{ $id }}">{{ $igvafectacion}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="igvafectacion_id" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="igvporciento_id">IGV Porcentaje</x-label>
                <x-select id="igvporciento_id" wire:model="igvporciento_id">
                    <option value="">Seleccione...</option>
                    @foreach ($igvporcientos as $id => $igvporciento)
                    <option value="{{ $id }}">{{ $igvporciento}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="igvporciento_id" />
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
        Livewire.on('rd', (e) => {
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
                            id: id
                        })
                    }
                })
            }
        }))
    </script>
    @endscript
</div>
