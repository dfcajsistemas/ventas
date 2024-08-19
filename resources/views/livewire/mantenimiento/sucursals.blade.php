<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Sucursales</h4>
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
                @can('mantenimiento.sucursals.agregar')
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
        @if ($sucursals->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Ubicación</th>
                        <th>Cod SUNAT</th>
                        <th>Estado</th>
                        @canany(['mantenimiento.sucursals.editar', 'mantenimiento.sucursals.estado'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sucursals as $sucursal)
                    <tr wire:key="{{ $sucursal->id }}">
                        <td>{{ $sucursal->id }}</td>
                        <td>{{ $sucursal->nombre }}</td>
                        <td>{{ $sucursal->direccion }}</td>
                        <td>{{ $sucursal->distrito->nombre }}</td>
                        <td>{{ $sucursal->cod_sunat }}</td>
                        <td><x-status :status="$sucursal->estado" /></td>
                        @canany(['mantenimiento.sucursals.editar', 'mantenimiento.sucursals.estado'])
                        <td>
                            @can('mantenimiento.sucursals.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $sucursal->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @can('mantenimiento.sucursals.estado')
                            <button class="btn btn-icon btn-secondary btn-sm" title="Estado"
                                wire:click="estado({{ $sucursal->id }})"><i class="tf-icons fa-solid fa-toggle-on"></i></button>
                            @endcan
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $sucursals->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @canany(['mantenimiento.sucursals.agregar', 'mantenimiento.sucursals.editar'])
    <x-modal-form mId="mModelo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="lg">
        <div class="row">
            <div class="col-12">
                <x-label for="nombre" value="Nombre" />
                <x-input type="text" id="nombre" wire:model="nombre" />
                <x-input-error for="nombre" />
            </div>
            <div class="col-12">
                <x-label for="direccion" value="Dirección" />
                <x-input type="text" id="direccion" wire:model="direccion" />
                <x-input-error for="direccion" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="telefono" value="Teléfono" />
                <x-input type="text" id="telefono" wire:model="telefono" />
                <x-input-error for="telefono" />
            </div>
            <div class="col-12 col-md-6">
                <x-label for="cod_sunat" value="Cod. SUNAT" />
                <x-input type="text" id="cod_sunat" wire:model="cod_sunat" />
                <x-input-error for="cod_sunat" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="departamento_id" value="Departamento" />
                <x-select id="departamento_id" wire:model.live="departamento_id">
                    <option value="">Seleccione Departamento</option>
                    @foreach ($departamentos as $departamento)
                    <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                    @endforeach
                </x-select>
                <x-input-error for="departamento_id" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="provincia_id" value="Provincia" />
                <x-select id="provincia_id" wire:model.live="provincia_id">
                    <option value="">Seleccione provincia</option>
                    @if ($provincias)
                    @foreach ($provincias as $prov)
                    <option value="{{$prov->id}}" {{$prov->id==$provincia_id ? 'selected' : ''}}>{{$prov->nombre}}</option>
                    @endforeach
                    @endif
                </x-select>
                <x-input-error for="provincia_id" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="distrito_id" value="Distrito" />
                <x-select id="distrito_id" wire:model="distrito_id">
                    <option value="">Seleccione distrito</option>
                    @if ($distritos)
                    @foreach ($distritos as $dist)
                    <option value="{{$dist->id}}" {{$dist->id==$distrito_id ? 'selected' : ''}}>{{$dist->nombre}}</option>
                    @endforeach
                    @endif
                </x-select>
                <x-input-error for="distrito_id" />
            </div>
        </div>
    </x-modal-form>
    @endcanany
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
    </script>
    @endscript
</div>

