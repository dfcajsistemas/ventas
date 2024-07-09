<?php

namespace App\Livewire\Accesos;

use Livewire\Component;

class UsersRoles extends Component
{
    public function render()
    {
        return view('livewire.accesos.users-roles')
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Usuarios - Roles']);
    }
}
