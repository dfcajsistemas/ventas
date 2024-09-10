<x-app-layout modulo="Despacho" pagina="Canasta">

    <h4><span class="text-muted fw-light">Despacho /</span> Canasta <span class="text-warning">(Sucursal:
            {{ $sucursal->nombre }})</span></h4>
    <div class="row">

        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <x-select id="cliente" class="select2 form-select-lg" data-allow-clear="true">
                                <option value="{{ $venta->cliente->id }}" selected>{{ $venta->cliente->razon_social }}
                                </option>
                            </x-select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-icon btn-warning"><i class="tf-icons fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="table-responsive pb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Queso Suizo 1Kg <button class="btn btn-icon btn-outline-danger btn-sm"><i
                                            class="tf-icons fa-solid fa-trash-can"></i></button></td>
                                <td>20.00</td>
                                <td>2.00 <button class="btn btn-icon btn-outline-warning btn-sm"><i
                                            class="tf-icons fa-solid fa-pen"></i></button></td>
                                <td>40.00</td>
                            </tr>
                            <tr>
                                <td>Yogut Lucuma 1L <button class="btn btn-icon btn-outline-danger btn-sm"><i
                                            class="tf-icons fa-solid fa-trash-can"></i></button></td>
                                <td>5.00</td>
                                <td>6.00 <button class="btn btn-icon btn-outline-warning btn-sm"><i
                                            class="tf-icons fa-solid fa-pen"></i></button></td>
                                <td>30.00</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total</td>
                                <td>70.00</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <button class="btn btn-primary">Guardar</button>
        </div>
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
            @if ($venta->productos->count())
                <div class="row mt-4">
                    @foreach ($productos as $producto)
                        <div class="col-md-3">
                            <div class="card text-center mb-3 p-0">
                                <a href="javascript:void(0)" wire:click='add({{ $producto->id }})'>
                                    <div class="card-body">
                                        <small class="text-info">{{ $producto->nombre }}</small><br>
                                        <span class="text-muted">Precio:
                                            {{ $producto->p_venta2 }}</span>
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

    @push('scripts')
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
            document.addEventListener('DOMContentLoaded', function() {
                $('#cliente').select2({
                    placeholder: 'Seleccione un cliente',
                    allowClear: true,
                    minimumInputLength: 3,
                    ajax: {
                        url: '{{ route('despacho.pedidos.bcliente') }}',
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.razon_social,
                                        id: item.id
                                    }
                                }),
                            }
                        },
                        cache: true
                    }
                });
            });

            $('#cliente').on('change', function(e) {
                var selectedValue = $(this).val();
                $.ajax({
                    url: '{{ route('despacho.pedidos.cliente') }}', // Ruta al controlador
                    type: 'put',
                    data: {
                        _token: '{{ csrf_token() }}', // Token CSRF para seguridad
                        cliente_id: selectedValue,
                        venta_id: '{{ $venta->id }}'
                    },
                    success: function(response) {
                        noti(response['m'], response['t']);

                    },
                    error: function(xhr, status, error) {
                        noti('Error al actualizar el cliente: ' + error, 'error');
                    }
                });
            });
        </script>
    @endpush



</x-app-layout>
