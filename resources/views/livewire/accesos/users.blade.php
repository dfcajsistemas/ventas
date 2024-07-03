<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Usuarios</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-12 col-md-9 mb-2 mb-md-0">
                    <input type="search" class="form-control" placeholder="Buscar..."
                        wire:model.live.debounce.300ms="search" wire:keydown.enter='search'>
                </div>
                <div class="col-4 col-md-1">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-4 col-md-2 d-grid">
                    <button class="btn btn-primary btn-block" wire:click='create'>
                        <i class="bx bx-plus me-0 me-sm-1"></i>
                        <span class="d-none d-sm-inline-block">Nuevo</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-noweap">
            <table class="table table-sm table-hover text-small">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->doc_numero }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->sucursal}}</td>
                        <td>
                            <x-status :status="$user->estado" />
                        </td>
                        <td>
                            <button class="btn btn-info btn-icon btn-sm" title="Editar"><i
                                    class='tf-icon bx bx-pencil'></i></button>
                            <button class="btn btn-secondary btn-icon btn-sm" title="Cambiar contraseña"><i
                                    class='tf-icon bx bxs-key'></i></button>
                            <button class="btn btn-warning btn-icon btn-sm" title="Asignar perfiles"><i
                                    class='tf-icon bx bxs-lock'></i></button>
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
                <label for="nameBasic" class="form-label">Name</label>
                <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" />
            </div>
        </div>
        <div class="row g-2">
            <div class="col mb-0">
                <label for="emailBasic" class="form-label">Email</label>
                <input type="email" id="emailBasic" class="form-control" placeholder="xxxx@xxx.xx" />
            </div>
            <div class="col mb-0">
                <label for="dobBasic" class="form-label">DOB</label>
                <input type="date" id="dobBasic" class="form-control" />
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
