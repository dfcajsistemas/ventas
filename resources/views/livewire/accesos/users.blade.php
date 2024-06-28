<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Lista de usuarios</h4>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-1">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-11">
                    <input type="search" class="form-control" placeholder="Buscar..."
                        wire:model.live.debounce.300ms="search" wire:keydown.enter='search'>
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
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->doc_numero }}</td>
                            <td>{{ $user->surname . ' ' . $user->name }}</td>
                            <td>
                                <x-status :status="$user->estado" />
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);">Cambiar contraseña</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Asignar Roles</a>
                                    </div>
                                </div>
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


            <div class="mt-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="openModal()">
                    Launch modal {{ $isOpen }}
                </button>

                <button type="button" class="btn btn-primary" onclick="modalComp()">
                    Prueba
                </button>

                <x-modal-form :mTitle="$mtitle" :mEvent="$mevent">
                </x-modal-form>

                <!-- Modal -->
                <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Name</label>
                                        <input type="text" id="nameBasic" class="form-control"
                                            placeholder="Enter Name" />
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="emailBasic" class="form-label">Email</label>
                                        <input type="email" id="emailBasic" class="form-control"
                                            placeholder="xxxx@xxx.xx" />
                                    </div>
                                    <div class="col mb-0">
                                        <label for="dobBasic" class="form-label">DOB</label>
                                        <input type="date" id="dobBasic" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    wire:click="$set('isOpen','0')">
                                    Close
                                </button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('basicModal'), {
                keyboard: false
            })

            var myModalCom = new bootstrap.Modal(document.getElementById('modalCom'), {
                keyboard: false
            })

            function openModal() {
                myModal.show()
            }

            function modalComp() {
                myModalCom.show()
            }

            myModalCom._element.addEventListener('hidden.bs.modal', function() {
                alert('cerrado')
            })
        </script>
    @endpush
</div>
