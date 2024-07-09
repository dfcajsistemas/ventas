<?php

namespace App\Livewire\Accesos;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermisos extends Component
{
    use WithPagination;

    public $role;
    public $search = '';
    public $perPage = '18';

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        $permisos = Permission::where('name', 'LIKE', "%".$this->search."%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.roles-permisos', compact('permisos'))
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Roles - Permisos']);;
    }

    public function syncPermiso($estado, $permiso)
    {
        if ($estado) {
            $this->role->givePermissionTo($permiso);
            $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso asignado.']);
        } else {
            $this->role->revokePermissionTo($permiso);
            $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso removido.']);
        }
    }
}
