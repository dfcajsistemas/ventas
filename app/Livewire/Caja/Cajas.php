<?php

namespace App\Livewire\Caja;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Cajas extends Component
{
    #[Title(['Cajas', 'Caja'])]
    public function render()
    {
        return view('livewire.caja.cajas');
    }
}
