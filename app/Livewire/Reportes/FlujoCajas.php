<?php

namespace App\Livewire\Reportes;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class FlujoCajas extends Component
{
    #[Title(['Flujo de cajas', 'Reportes'])]
    public function render()
    {
        return view('livewire.reportes.flujo-cajas');
    }
}
