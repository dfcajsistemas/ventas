<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Roles</h4>
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
                @can('accesos.roles.agregar')
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
        @if ($roles->count())
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Guardia</th>
                        <th>Usuarios</th>
                        @canany(['accesos.roles.editar', 'accesos.roles.permisos', 'accesos.roles.eliminar'])
                        <th>Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr wire:key="{{ $role->id }}">
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>{{ $role->users()->count() }}</td>
                        @canany(['accesos.roles.editar', 'accesos.roles.permisos', 'accesos.roles.eliminar'])
                        <td>
                            @can('accesos.roles.editar')
                            <button class="btn btn-icon btn-info btn-sm" title="Editar"
                                wire:click="edit({{ $role->id }})"><i class="tf-icons fa-solid fa-pen"></i></button>
                            @endcan
                            @can('accesos.roles.permisos')
                            <a href="{{ route('accesos.roles.permisos', $role->id) }}"
                                class="btn btn-icon btn-secondary btn-sm" title="Permisos"><i
                                    class="tf-icons fa-solid fa-lock"></i></a>
                            @endcan
                            @can('accesos.roles.eliminar')
                            @if ($role->users()->count() == 0)
                            <button x-data="eliminar" class="btn btn-icon btn-danger btn-sm" title="Eliminar"
                                x-on:click="confirmar({{ $role->id }})"><i
                                    class="tf-icons fa-solid fa-trash"></i></button>
                            @endif
                            @endcan
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="m-3">
            {{ $roles->links() }}
        </div>
        @else
        <div class="mx-3 mb-3">
            <x-msg type="info" msg="No se encontraron resultados" />
        </div>
        @endif
    </div>
    @canany(['accesos.roles.agregar', 'accesos.roles.editar'])
    <x-modal-form mId="mRol" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col">
                <x-label class="form-label" for="name">Nombre</x-label>
                <x-input class="form-control" type="text" id="name" wire:model="name" />
                <x-input-error for="name" />
            </div>
        </div>
    </x-modal-form>
    @endcanany
    @script
    <script>
        Livewire.on('sm', (e) => {
            $("#mRol").modal('show')
        });
        Livewire.on('hm', (e) => {
            $("#mRol").modal('hide')
            noti(e[0]['m'], e[0]['t'])
        })
        Livewire.on('rd', (e) => {
            noti(e[0]['m'], e[0]['t'])
        })

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
                            id: id
                        })
                    }
                })
            }
        }))
    </script>
    @endscript
</div>
