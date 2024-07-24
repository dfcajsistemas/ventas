<?php

namespace App\Livewire\Mantenimiento;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Productos extends Component
{
    #[Title(['Dashboard', 'Mantenimiento'])]
    public function render()
    {
        return view('livewire.mantenimiento.productos');
    }
}
