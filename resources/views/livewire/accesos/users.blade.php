<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Usuarios</h4>
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
                @can('accesos.users.agregar')
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-primary" wire:click='create' title="Nuevo">
                        <i class="tf-icons bx bx-plus"></i>
                    </button>
                </div>
                @endcan
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="exportar()"><i
                            class="t-icons fa-solid fa-file-excel"></i></button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>T. Doc</th>
                        <th>N. Doc</th>
                        <th>Nombre</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr wire:key='f{{$user->id}}'>
                        <td>{{ $user->id }}</td>
                        <th>{{ $user->tdocumento->abreviatura}}</th>
                        <td>{{ $user->ndocumento }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->sucursal->nombre}}</td>
                        <td>
                            <x-status :status="$user->estado" />
                        </td>
                        <td>
                            @can('accesos.users.editar')
                            <button class="btn btn-info btn-icon btn-sm mb-sm-1 mb-md-0" title="Editar"
                                wire:click='edit({{$user->id}})'><i class='tf-icon bx bx-pencil'></i></button>
                            @endcan
                            @can('accesos.users.password')
                            <button class="btn btn-secondary btn-icon btn-sm" title="Cambiar contraseña"
                                wire:click='editPassword({{$user->id}})'><i class='tf-icon bx bxs-key'></i></button>
                            @endcan
                            @can('accesos.users.roles')
                            <a href="{{route('accesos.users.roles', $user->id)}}"
                                class="btn btn-success btn-icon btn-sm" title="Asignar perfiles"><i
                                    class='tf-icon bx bxs-lock'></i></a>
                            @endcan
                            @can('accesos.users.estado')
                            <button wire:click='estado({{$user->id}})' class="btn btn-warning btn-icon btn-sm"
                                title="Desactivar"><i class='tf-icon bx bxs-toggle-right'></i></button>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No se encontraron resultados</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="m-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <x-modal-form mId="mUser" :mTitle="$mTitle" :mMethod="$mMethod">
        <div class="row">
            <div class="col mb-3">
                <x-input wire:model='name' type="text" id="name" placeholder="NOMBRE" />
                <x-input-error for="name" />
            </div>
        </div>
        <div class="row g-3">
            <div class="col-6 mb-3">
                <x-select wire:model='tdocumento_id' id="tdocumento_id">
                    <option value="" selected>TIPO DOCUMENTO</option>
                    @foreach ($tdocumentos as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="tdocumento_id" />
            </div>
            <div class="col-4">
                <x-input wire:model='ndocumento' type="text" id="ndocumento" placeholder="# DOCUMENTO" />
                <x-input-error for="ndocumento" />
            </div>
            <div class="col-2">
                <x-danger-button><i class="tf-icons bx bx-search"></i></x-danger-button>
            </div>
        </div>
        <div class="row g-2">
            <div class="col mb-3">
                <x-input wire:model='fec_nac' type="date" id="fec_nac" placeholder="FECHA NACIMIENTO" />
                <x-input-error for="fec_nac" />
            </div>
            <div class="col mb-3">
                <x-input wire:model='email' type="email" id="email" placeholder="EMAIL" />
                <x-input-error for="email" />
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <x-select wire:model='sucursal_id' id="sucursal_id">
                    <option value="" selected>SUCURSAL</option>
                    @foreach ($sucursales as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="sucursal_id" />
            </div>
        </div>
    </x-modal-form>
    @can('accesos.users.password')
    <x-modal-form mId="mPass" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm" :kb="$kb">
        <div class="row">
            <div class="col-12">
                <h6 class="text-info"><i class='bx bx-user text-muted ml-2'></i> {{ $name }}</h6>
            </div>
            <div class="col-12 mb-2">
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <x-input type="text" id="password" wire:model="password" wire:keydown.enter="updatePassword()" />
                    <x-input-error for="password" />
                </div>
            </div>
            <div class="col-12 d-grid">
                <button x-data="generar" type="button" class="btn btn-warning" x-on:click="gPassword()" title="Generar contraseña"><i
                        class='tf-icons bx bx-key me-1'></i>Generar</button>
            </div>
        </div>
    </x-modal-form>
    @endcan
    @script
    <script>
        Livewire.on('sm', (e) => {
            $("#mUser").modal('show')
        });
        Livewire.on('hm', (e) => {
            $("#mUser").modal('hide')
            noti(e[0]['m'], e[0]['t'])
        });
        Livewire.on('sp', (e) => {
            $("#mPass").modal('show')
        });
        Livewire.on('hp', (e) => {
            $("#mPass").modal('hide')
            noti(e[0]['m'], e[0]['t'])
        });

        Alpine.data('generar', () => ({
            gPassword() {
                var pass = "";
                for (i = 0; i < 8; i++) {
                    pass += String.fromCharCode((Math.floor((Math.random() * 100)) % 94) + 33);
                }
                @this.set('password', pass);
            }
        }))
    </script>
    @endscript
</div>
