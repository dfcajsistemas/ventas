<?php

namespace App\Livewire\Accesos;

use App\Models\User;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Lazy()]
class Dashboard extends Component
{
    #[Title(['Dashboard', 'Accesos'])]
    public function render()
    {
        $tusers= User::where('estado', 1)->count();
        $troles= Role::count();
        $tpermisos= Permission::count();
        return view('livewire.accesos.dashboard', compact('tusers', 'troles', 'tpermisos'));
    }
}
