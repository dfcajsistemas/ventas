<div>
    <h4><span class="text-muted fw-light">Accesos /</span> Roles - Permisos</h4>
    <div class="row">
        <div class="col-12 @can('accesos.roles.permisos.asignar') col-md-4 mb-3 mb-md-0 @endcan">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rol</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-info"><i class="fa-solid fa-lock text-muted"></i> {{ $role->name }}</h4>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Permisos</small><br>
                            @forelse ($role->permissions->sortBy('name') as $permission)
                                <span class="badge bg-success mb-1">{{ $permission->name }}</span>
                            @empty
                                <span class="badge bg-label-secondary mb-1">Sin permisos asignados</span>
                            @endforelse
                        </div>
                        <div class="col-12 mt-2">
                            <a href="{{ route('accesos.roles') }}" class="btn btn-outline-primary"><i
                                    class="fa-solid fa-angle-left me-1"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('accesos.roles.permisos.asignar')
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Asignar permisos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <input type="search" class="form-control" placeholder="Buscar permisos..."
                                wire:model.live.debounce.300ms="search">
                        </div>
                        @foreach ($permisos as $permiso)
                            <div class="col-12 col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="per_{{ $permiso->id }}"
                                        value="{{ $permiso->id }}" name="permisos[]"
                                        wire:click="syncPermiso({{ $role->hasPermissionTo($permiso->id) ? 1 : 0 }}, '{{ $permiso->name }}')"
                                        {{ $role->hasPermissionTo($permiso->id) ? 'checked' : '' }}>
                                    <x-label for="per_{{ $permiso->id }}"
                                        class="form-check-label">{{ $permiso->name }}</x-label>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            {{ $permisos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    @script
    <script>
        Livewire.on('re', (e) => {
            noti(e[0]['m'], e[0]['t'])
        })
    </script>
    @endscript
</div>

