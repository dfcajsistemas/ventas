<x-app-layout modulo="Despacho" pagina="Canasta">

    <h4><span class="text-muted fw-light">Despacho /</span> Canasta <span class="text-primary"><i
                class="fa-solid fa-store text-muted"></i>
            {{ $sucursal->nombre }}</span></h4>
    <div class="row">

        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2 d-flex align-items-center">
                            P:&nbsp;<span class="text-primary fw-bold"> {{ $venta->id }}</span>
                        </div>
                        @if (!$venta->est_venta)
                            <div class="col-md-8">
                                <x-select id="cliente" class="select2 form-select-lg" data-allow-clear="true">
                                    <option value="{{ $venta->cliente->id }}" selected>
                                        {{ $venta->cliente->razon_social }}
                                    </option>
                                </x-select>
                            </div>
                            @livewire('despacho.cliente')
                        @else
                            <div class="col-md-7">
                                C: {{ $venta->cliente->razon_social }}
                            </div>
                            <div class="col-md-3">
                                T:&nbsp;<span
                                    class="text-warning fw-bold">{{ $venta->ser_ticket . '-' . $venta->cor_ticket }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @livewire('despacho.cproductos', ['venta' => $venta->id])

        </div>
        <div class="col-md-5">
            @livewire('despacho.bproductos', ['venta' => $venta->id])
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#cliente').each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Seleccione un cliente',
                        minimumInputLength: 3,
                        dropdownParent: $this.parent(),
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
                                        };
                                    })
                                };
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

            });
        </script>
    @endpush
</x-app-layout>
