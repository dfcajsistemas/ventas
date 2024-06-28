<?php

namespace App\Livewire\Accesos;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.accesos.dashboard')
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Dashboard']);
    }
}
