<?php

namespace App\Livewire\Reportes;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Inventario extends Component
{
    #[Title(['Inventario', 'Reportes'])]
    public function render()
    {
        return view('livewire.reportes.inventario');
    }
}
