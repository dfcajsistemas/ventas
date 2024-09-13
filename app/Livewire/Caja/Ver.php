<?php

namespace App\Livewire\Caja;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Lazy()]
class Ver extends Component
{
    #[Title(['Ver Caja', 'Caja'])]
    public function render()
    {
        return view('livewire.caja.ver');
    }
}
