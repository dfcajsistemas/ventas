<div>
    <h4><span class="text-muted fw-light">Caja /</span> Cajas <span class="text-warning">(Sucursal:
        {{ $sucursal->nombre }})</span></h4>
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
                @can('caja.cajas.agregar')
                    <div class="col-4 col-md-1 d-grid">
                        <button class="btn btn-primary" title="Nueva caja" wire:click="create()"><i
                                class="tf-icons fa-solid fa-plus"></i></button>
                    </div>
                @endcan
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="exportar()"><i
                            class="tf-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>
        @if ($cajas->count())
            <div class="table-responsive text-noweap">
                <table class="table table-sm table-hover text-small">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Responsable</th>
                            <th>F. Apertura</th>
                            <th>F. Cierre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cajas as $caja)
                            <tr wire:key="{{ $caja->id }}">
                                <td>{{ $caja->id }}</td>
                                <td>{{ $caja->name }}</td>
                                <td>{{ date('d/m/Y', strtotime($caja->apertura)) }}</td>
                                <td>{{ $caja->cierre ? date('d/m/Y', strtotime($caja->cierre)) : '' }}</td>
                                <td>
                                    <a href="{{ route('caja.cajas.ver', $caja->id) }}"
                                        class="btn btn-icon btn-warning btn-sm"><i
                                            class="tf-icons fa-solid fa-cash-register"></i></a>
                                    @can('caja.cajas.eliminar')
                                        @if ($caja->cierre == null)
                                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm"
                                                title="Eliminar"
                                                x-on:click="confirmar({{ $caja->id }}, '{{ $caja->name }}')"><i
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
                {{ $cajas->links() }}
            </div>
        @else
            <div class="mx-3 mb-3">
                <x-msg type="info" msg="No se encontraron resultados" />
            </div>
        @endif
    </div>
    @can('caja.cajas.agregar')
        <x-modal-form mId="mModelo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
            <div class="row">
                <div class="col text-center">
                    <span>Se creará una caja a nombre de:</span>
                    <h4 class="text-warning">{{ auth()->user()->name }}</h4>
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

            Alpine.data('eliminar', () => ({
                confirmar(id, nom) {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: "¡No podrás revertir esto!<br>caja de: <b>" + nom + "</b>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('delete', {
                                caja: id
                            })
                        }
                    })
                }
            }))
        </script>
    @endscript
</div>
