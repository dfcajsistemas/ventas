<?php

namespace App\Livewire\Accesos;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.accesos.index')
                    ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Dashboard']);
    }
}
