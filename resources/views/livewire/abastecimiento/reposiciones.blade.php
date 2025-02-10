<div>
    <h4><span class="text-muted fw-light">Abastecimiento /</span> Reposiciones</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <span class="text-success" style="font-size: 1.3em;">{{ $producto->nombre }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover text-small border-top">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <th>DESCRIPCIÓN</th>
                                <td>{{ $producto->descripcion }}</td>
                            </tr>
                            <tr>
                                <th>CÓDIGO</th>
                                <td>{{ $producto->codigo }}</td>
                            </tr>
                            <tr>
                                <th>CATEGORIA</th>
                                <td>{{ $producto->categoria->nombre }}</td>
                            </tr>
                            <tr>
                                <th>U. MEDIDA</th>
                                <td>{{ $producto->umedida->descripcion }}</td>
                            </tr>
                            <tr>
                                <th>P. COSTO</th>
                                <td>{{ $producto->p_costo }}</td>
                            </tr>
                            @if ($sucursal->id == 1)
                                <tr>
                                    <th>P. VENTA 1</th>
                                    <td>{{ $producto->p_venta1 }}</td>
                                </tr>
                            @elseif ($sucursal->id == 2)
                                <tr>
                                    <th>P. VENTA 2</th>
                                    <td>{{ $producto->p_venta2 }}</td>
                                </tr>
                            @elseif ($sucursal->id == 3)
                                <tr>
                                    <th>P. VENTA 3</th>
                                    <td>{{ $producto->p_venta3 }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>IGV AFECTACIÓN</th>
                                <td>{{ $producto->igvafectacion->descripcion }}</td>
                            </tr>
                            <tr>
                                <th>IGV PORCENTAJE</th>
                                <td>{{ $producto->igvporciento->porcentaje }}</td>
                            </tr>
                            <tr>
                                <th>ICBPER</th>
                                <td>{{ $producto->icbper ? 'Si' : 'No' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-sm table-hover text-small">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <th>STOCK</th>
                                <td><b
                                        class="text-{{ $stock->stock > $stock->stock_minimo ? 'info' : 'danger' }}">{{ $stock->stock }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th>STOCK MÍNIMO</th>
                                <td>{{ $stock->stock_minimo }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ route('abastecimiento.productos') }}" class="btn btn-secondary mt-3 mb-3 mb-sm-0"><i
                    class='bx bx-left-arrow-alt e-2'></i>Productos</a>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-2 col-md-4">
                            <x-input type='date' wire:model.live='desde' />
                        </div>
                        <div class="col-2 col-md-4">
                            <x-input type='date' wire:model.live='hasta' />
                        </div>
                        <div class="col-2 col-md-2">
                            <select class="form-select" wire:model.live="perPage">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        @can('abastecimiento.productos.reposiciones.agregar')
                            <div class="col-3 col-md-1 d-grid">
                                <button class="btn btn-primary" title="Nuevo" wire:click="create()"><i
                                        class="tf-icons fa-solid fa-plus"></i></button>
                            </div>
                        @endcan
                        <div class="col-3 col-md-1 d-grid">
                            <button class="btn btn-label-secondary" title="Exportar" wire:click="export()"><i
                                    class="tf-icons fa-solid fa-file-excel"></i></button>
                        </div>
                    </div>
                </div>
                @if ($reposiciones->count())
                    <div class="table-responsive text-noweap">
                        <table class="table table-sm table-hover text-small">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Lote</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $n = 0;
                                @endphp
                                @foreach ($reposiciones as $reposicion)
                                    @php
                                        $n++;
                                    @endphp
                                    <tr wire:key="{{ $reposicion->id }}">
                                        <td>{{ $reposicion->id }}</td>
                                        <td>{{ $reposicion->lote }}</td>
                                        <td>{{ $reposicion->cantidad }}</td>
                                        <td>{{ date('d/m/Y', strtotime($reposicion->created_at)) }}</td>
                                        <td>
                                            <button class="btn btn-icon btn-success btn-sm" title="Detalle"
                                                wire:click="details({{ $reposicion->id }})"><i
                                                    class="tf-icons fa-solid fa-list"></i></button>
                                            @can('abastecimiento.productos.reposiciones.eliminar')
                                                @if ($n == 1)
                                                    <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm"
                                                        title="Eliminar" x-on:click="confirmar({{ $reposicion->id }})"><i
                                                            class="tf-icons fa-solid fa-trash"></i></button>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="m-3">
                        {{ $reposiciones->links() }}
                    </div>
                @else
                    <div class="mx-3 mb-3">
                        <x-msg type="info" msg="No se encontraron resultados" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    @can('abastecimiento.productos.reposiciones.agregar')
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
    <x-modal-view mId="mDetails" :mTitle="$mTitle" mSize="md">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-small">
                <tr>
                    <th>Cantidad</th>
                    <td>{{ $cantidad }}</td>
                </tr>
                <tr>
                    <th>Lote</th>
                    <td>{{ $lote }}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{{ $observaciones }}</td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ date('d/m/Y H:i:s', strtotime($created_at)) }}</td>
                </tr>
            </table>
        </div>
    </x-modal-view>
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
