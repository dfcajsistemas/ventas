<div>
    <h4><span class="text-muted fw-light">Despacho /</span> despacho <span class="text-warning">(Sucursal:
            {{ $sucursal->nombre }})</span></h4>
    <div class="row">

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 mb-2 mb-md-0">
                            <input type="search" class="form-control" placeholder="Buscar..."
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
            </div>
            @if ($productos->count())
                <div class="row mt-4">
                    @foreach ($productos as $producto)
                        <div class="col-md-3">
                            <div class="card text-center mb-3 p-0">
                                <a href="javascript:void(0)" wire:click='add({{ $producto->id }})'>
                                    <div class="card-body">
                                        <span class="text-info">{{ $producto->nombre }}</span><br>
                                        <span class="text-muted">Precio:
                                            {{ $producto->p_venta1 }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
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
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-info">Canasta</h5>
                </div>
                <div class="table-responsive pb-4">

                </div>
            </div>

        </div>
    </div>
    @can('despacho.despachar.agregar')
        <x-modal-form mId="mModelo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="md">
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-label for="cantidad">Cantidad</x-label>
                    <x-input type="number" id="cantidad" wire:model="cantidad" />
                    <x-input-error for="cantidad" />
                </div>
                <div class="col-12 col-md-6">
                    <x-label for="lote">Lote</x-label>
                    <x-input type="text" id="lote" wire:model="lote" />
                    <x-input-error for="lote" />
                </div>
                <div class="col-12">
                    <x-label for="observaciones">Observaciones</x-label>
                    <x-input type="text" id="observaciones" wire:model="observaciones" />
                    <x-input-error for="observaciones" />
                </div>
            </div>
        </x-modal-form>
    @endcan
    @script
        <script>
            Livewire.on('sm', (e) => {
                $("#mModelo").modal('show')
            });
            Livewire.on('hm', (e) => {
                $("#mModelo").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('re', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Livewire.on('smd', (e) => {
                $("#mDetails").modal('show')
            });

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
                                reposicion: id
                            })
                        }
                    })
                }
            }))
        </script>
    @endscript
</div>
