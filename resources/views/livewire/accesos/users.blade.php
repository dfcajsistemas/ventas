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
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-primary" wire:click='create' title="Nuevo">
                        <i class="tf-icons bx bx-plus"></i>
                    </button>
                </div>
                <div class="col-4 col-md-1 d-grid">
                    <button class="btn btn-label-secondary" title="Exportar" wire:click="exportar()"><i class="t-icons fa-solid fa-file-excel"></i></button>
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
                            <button class="btn btn-info btn-icon btn-sm mb-sm-1 mb-md-0" title="Editar"><i
                                    class='tf-icon bx bx-pencil'></i></button>
                            <button class="btn btn-secondary btn-icon btn-sm" title="Cambiar contraseña"><i
                                    class='tf-icon bx bxs-key'></i></button>
                            <button class="btn btn-success btn-icon btn-sm" title="Asignar perfiles"><i
                                    class='tf-icon bx bxs-lock'></i></button>
                                    <button wire:click='estado({{$user->id}})' class="btn btn-warning btn-icon btn-sm" title="Desactivar"><i class='tf-icon bx bxs-toggle-right' ></i></button>
                            <button class="btn btn-danger btn-icon btn-sm" title="Eliminar"><i
                                    class='tf-icon bx bx-trash'></i></button>
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
        <div class="row g-2">
            <div class="col mb-3">
                <x-input wire:model='password' type="password" id="password" placeholder="CONTRASEÑA" />
                <x-input-error for="password" />
            </div>
            <div class="col mb-3">
                <x-input wire:model='cpassword' type="password" id="cpassword" placeholder="REPETIR CONTRASEÑA" />
                <x-input-error for="cpassword" />
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
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const mUser = new bootstrap.Modal('#mUser', {
                keyboard: false
            })
            Livewire.on('sm', (e) => {
                mUser.show()
            });
            Livewire.on('hm', (e) => {
                mUser.hide()
                noti(e[0]['m'], e[0]['t'])
            });
        })
    </script>
    @endpush
</div>
