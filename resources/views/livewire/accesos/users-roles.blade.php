<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Users - Roles</h4>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Usuario</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-info"><i class="fa-solid fa-user text-muted"></i>
                                {{ $user->name }}</h5>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Roles</small><br>
                            @forelse ($user->roles->sortBy('name') as $role)
                            <span class="badge bg-success mb-1">{{ $role->name }}</span>
                            @empty
                            <span class="badge bg-label-secondary mb-1">Sin roles asignados</span>
                            @endforelse
                        </div>
                        <div class="col-12 mt-2">
                            <a href="{{ route('accesos.users') }}" class="btn btn-outline-primary"><i
                                    class="fa-solid fa-angle-left me-1"></i>Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Asignar roles</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <input type="search" class="form-control" placeholder="Buscar roles..."
                                wire:model.live.debounce.300ms="search">
                        </div>
                        @foreach ($roles as $role)
                        <div class="col-12 col-md-4 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rol_{{ $role->id }}"
                                    value="{{ $role->id }}" name="roles[]"
                                    wire:click="syncRole({{ $user->roles->contains($role->id) ? 1 : 0 }}, '{{ $role->name }}')"
                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                <x-label for="rol_{{ $role->id }}" class="form-check-label">{{ $role->name }}</x-label>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-12">
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @script
    <script>
        Livewire.on('re', (e) => {
            noti(e[0]['m'], e[0]['t'])
        })
    </script>
    @endscript
</div>
