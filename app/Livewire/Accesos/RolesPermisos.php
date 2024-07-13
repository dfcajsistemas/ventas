<?php

namespace App\Livewire\Accesos;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Lazy()]
class RolesPermisos extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '30')]
    public $perPage = '30';
    public $role;

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Title(['Roles - Permisos', 'Accesos'])]
    public function render()
    {
        $permisos = Permission::where('name', 'LIKE', "%".$this->search."%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.roles-permisos', compact('permisos'));
    }

    public function syncPermiso($estado, $permiso)
    {
        if (!$estado) {
            $this->role->givePermissionTo($permiso);
            $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso asignado.']);
        } else {
            $this->role->revokePermissionTo($permiso);
            $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso removido.']);
        }
    }
}
