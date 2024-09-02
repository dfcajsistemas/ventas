<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Clientes</h4>
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
                @can('mantenimiento.clientes.agregar')
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
        @if ($clientes->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre/Raz. Social</th>
                        <th>T. Documento</th>
                        <th>N. Documento</th>
                        <th>Estado</th>
                        @canany(['mantenimiento.clientes.editar', 'mantenimiento.clientes.eliminar'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                    <tr wire:key="{{ $cliente->id }}">
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->razon_social }}</td>
                        <td>{{ $cliente->tdocumento->abreviatura }}</td>
                        <td>{{ $cliente->ndocumento }}</td>
                        <td><x-status :status="$cliente->estado" /></td>
                        @canany(['mantenimiento.clientes.editar', 'mantenimiento.clientes.eliminar'])
                        <td>
                            @can('mantenimiento.clientes.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $cliente->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @can('mantenimiento.clientes.estado')
                            <button class="btn btn-icon btn-secondary btn-sm" title="Estado"
                                wire:click="status({{ $cliente->id }})"><i class="tf-icons fa-solid fa-toggle-on"></i></button>
                            @endcan
                            @can('mantenimiento.clientes.eliminar')
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $cliente->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endcan
                            <button class="btn btn-icon btn-success btn-sm" title="Ver"
                                wire:click="view({{ $cliente->id }})"><i class="tf-icons fa-solid fa-eye"></i>
                            </button>
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $clientes->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @canany(['mantenimiento.clientes.agregar', 'mantenimiento.clientes.editar'])
    <x-modal-form mId="mModelo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="md">
        <div class="row">
            <div class="col-4">
                <x-label for="tdocumento">Tipo Documento</x-label>
                <x-select id="tdocumento" wire:model="tdocumento">
                    <option value="">Seleccione...</option>
                    @foreach ($tdocumentos as $k=>$tdocumento)
                    <option value="{{ $k }}">{{ $tdocumento }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="tdocumento" />
            </div>
            <div class="col-6">
                <x-label for="ndocumento"># Documento</x-label>
                <x-input type="text" id="ndocumento" wire:model="ndocumento" />
                <x-input-error for="ndocumento" />
            </div>
            <div class="col-2 d-flex align-items-end">
                <button class="btn btn-warning btn-lg" title="Buscar y rellenar" wire:click='bDocumento' wire:loading.attr='disabled'>
                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true" wire:loading wire:target='bDocumento'></span>
                    <i class="tf-icons fa-solid fa-magnifying-glass" wire:loading.remove wire:target='bDocumento'></i>
                </button>
            </div>
            <div class="col-12">
                <x-label for="razon_social">Nombre/Razon Social</x-label>
                <x-input type="text" id="razon_social" wire:model="razon_social" />
                <x-input-error for="razon_social" />
            </div>
            <div class="col-12">
                <x-label for="direccion">Dirección</x-label>
                <x-input type="text" id="direccion" wire:model="direccion" />
                <x-input-error for="direccion" />
            </div>
            <div class="col-8">
                <x-label for="referencia">Referencia</x-label>
                <x-input type="text" id="referencia" wire:model="referencia" />
                <x-input-error for="referencia" />
            </div>
            <div class="col-4">
                <x-label for="ubigeo">Ubigeo</x-label>
                <x-input type="text" id="ubigeo" wire:model="ubigeo" />
                <x-input-error for="ubigeo" />
            </div>
            <div class="col-5">
                <x-label for="telefono">Teléfono</x-label>
                <x-input type="text" id="telefono" wire:model="telefono" />
                <x-input-error for="telefono" />
            </div>
            <div class="col-7">
                <x-label for="correo">Correo</x-label>
                <x-input type="email" id="correo" wire:model="correo" />
                <x-input-error for="correo" />
            </div>
        </div>
    </x-modal-form>
    @endcanany
    <x-modal-view mId="mVer" :mTitle="$mTitle" mSize="md">
        <div class="table-responsive">
            @if($vcliente)
            <table class="table table-sm table-hover text-small">
                <tbody>
                    <tr>
                        <th colspan="2"><small>Nombre/Razón Social</small><h5 class="text-info">{{ $vcliente->razon_social }}</h5></th>
                    </tr>
                    <tr>
                        <th>T. Documento</th>
                        <td>{{ $vcliente->tdocumento->abreviatura }}</td>
                    </tr>
                    <tr>
                        <th># Documento</th>
                        <td>{{ $vcliente->ndocumento }}</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>{{ $vcliente->direccion }}</td>
                    </tr>
                    <tr>
                        <th>Referencia</th>
                        <td>{{ $vcliente->referencia }}</td>
                    </tr>
                    <tr>
                        <th>Ubigeo</th>
                        <td>{{ $vcliente->ubigeo }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $vcliente->telefono }}</td>
                    </tr>
                    <tr>
                        <th>Correo</th>
                        <td>{{ $vcliente->correo }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td><x-status :status="$vcliente->estado" /></td>
                    </tr>
                </tbody>
            </table>
            @endif
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

        Livewire.on('smv', (e) => {
            $("#mVer").modal('show')
        })
    </script>
    @endscript
</div>
