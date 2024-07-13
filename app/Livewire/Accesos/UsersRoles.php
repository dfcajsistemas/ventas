<?php

namespace App\Livewire\Accesos;

use App\Models\User;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Lazy()]
class UsersRoles extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '18')]
    public $perPage = '18';
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Title(['Usuarios - Roles', 'Accesos'])]
    public function render()
    {
        $roles = Role::where('name', 'LIKE', "%".$this->search."%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.users-roles', compact('roles'));
    }

    public function syncRole($estado, $role)
    {
        if (!$estado) {
            $this->user->assignRole($role);
            $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Rol asignado.']);
        } else {
            $this->user->removeRole($role);
            $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Rol removido.']);
        }
    }
}
