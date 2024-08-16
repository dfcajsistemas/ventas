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
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr wire:key="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td><x-status :status="$producto->estado" /></td>
                        <td>
                            @can('mantenimiento.productos.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $producto->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @can('mantenimiento.productos.estado')
                            <button class="btn btn-icon btn-secondary btn-sm" title="Editar"
                                wire:click="status({{ $producto->id }})"><i class="tf-icons fa-solid fa-toggle-off"></i></button>
                            @endcan
                            <button class="btn btn-icon btn-success btn-sm" title="Detalle"
                                wire:click="details({{ $producto->id }})"><i class="tf-icons fa-solid fa-list"></i></button>
                        </td>
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
            <div class="col-12 col-md-6">
                <div class="form-check pt-4">
                    <x-checkbox id="icbper" value="1" wire:model="icbper" />
                    <x-label for="icbper" value="ICBPER" />
                </div>
            </div>
        </div>
    </x-modal-form>
    @endcanany
    <x-modal-view mId="mDetails" :mTitle="$mTitle" mSize="md">
        <div class="table-responsive">
            @if($prod)
            <table class="table table-sm table-hover text-small">
                <tr>
                    <td>Nombre</td>
                    <td class="text-info"><b>{{ $prod->nombre }}</b></td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td>{{ $prod->descripcion }}</td>
                </tr>
                <tr>
                    <td>Código</td>
                    <td>{{ $prod->codigo }}</td>
                </tr>
                <tr>
                    <td>Categoria</td>
                    <td>{{ $prod->categoria->nombre }}</td>
                </tr>
                <tr>
                    <td>U. Medida</td>
                    <td>{{$prod->umedida->descripcion}}</td>
                </tr>
                <tr>
                    <td>IGV Afectación</td>
                    <td>{{$prod->igvafectacion->descripcion}}</td>
                </tr>
                <tr>
                    <td>IGV Porcentaje</td>
                    <td>{{$prod->igvporciento->porcentaje}}</td>
                </tr>
                <tr>
                    <td>ICBPER</td>
                    <td>{{ $prod->icbper ? 'Si' : 'No' }}</td>
                </tr>
            </table>
            @endif
        </div>
    </x-modal-view>
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
        Livewire.on('smd', (e) => {
            $("#mDetails").modal('show')
        });
    </script>
    @endscript
</div>
