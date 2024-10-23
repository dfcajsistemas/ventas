<div>
    <div class="card mb-4">
        <div class="table-responsive">
            @if ($productos->count())
                <table class="table table-hover" style="font-size: 0.9em;">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-end">Cant.</th>
                            <th class="text-end">PU</th>
                            <th class="text-end">Total</th>
                            @if (!$cventa->est_venta)
                                <th class="text-end" width="132">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @foreach ($productos as $producto)
                            @php
                                $t += $producto->total;
                            @endphp
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td class="text-end">{{ $producto->cantidad }}</td>
                                <td class="text-end">{{ $producto->precio }}</td>
                                <td class="text-end">{{ number_format($producto->total, 2) }}</td>
                                @if (!$cventa->est_venta)
                                    <td class="text-end">
                                        <button class="btn btn-icon btn-outline-info btn-sm"
                                            wire:click='ecantidad({{ $producto->id }})' title="Editar cantidad"><i
                                                class="tf-icons fa-solid fa-hashtag"></i></button>
                                        <button class="btn btn-icon btn-outline-warning btn-sm"
                                            wire:click='eprecio({{ $producto->id }})' title="Editar precio"><i
                                                class="tf-icons fa-solid fa-money-bill-1"></i></button>
                                        <button class="btn btn-icon btn-outline-danger btn-sm" x-data="eliminar"
                                            x-on:click="confirmar({{ $producto->id }}, '{{ $producto->nombre }}')"
                                            title="Eliminar"><i class="tf-icons fa-solid fa-trash-can"></i></button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <thead class="table-border-bottom-0">
                        <tr>
                            <th colspan="3" class="fw-bold">Total</th>
                            <th class="text-end fw-bold">{{ number_format($t, 2) }}</th>
                            @if (!$cventa->est_venta)
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                </table>
            @else
                <div class="m-3">
                    <x-msg type="info" msg="Canasta vacia" />
                </div>
            @endif
        </div>
    </div>
    <a href="{{ route('despacho.pedidos') }}" class="btn btn-icon btn-secondary"><i
            class='bx bx-left-arrow-alt'></i></a>
    @if ($productos->count())
        @if ($cventa->est_venta)
            <button class="btn btn-success" wire:click='impTicket'><i class="fa-solid fa-receipt me-2"></i>
                Imprimir
                Ticket</button>
        @else
            <button class="btn btn-info" wire:click='genPedido'><i class="fa-solid fa-boxes-packing me-2"
                    title="Generar Pedido"></i> Generar
                Pedido</button>
        @endif
    @endif
    <x-modal-form mId="mCan" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col">
                <x-label for="cantidad">Cantidad</x-label>
                <x-input type="number" id="cantidad" wire:model="cantidad" />
                <x-input-error for="cantidad" />
            </div>
        </div>
    </x-modal-form>
    @script
        <script>
            Livewire.on('smca', (e) => {
                $("#mCan").modal('show')
            });
            Livewire.on('hmca', (e) => {
                $("#mCan").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('reca', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })

            Alpine.data('eliminar', () => ({
                confirmar(id, nom) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "¡Eliminarás!<p><strong>" + nom + "</strong></p>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete', {
                                dventa: id
                            })
                        }
                    })
                }
            }))
        </script>
    @endscript
</div>
