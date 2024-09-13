<?php

namespace App\Livewire\Caja;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Cobrar extends Component
{
    public $sucursal;

    public function mount(){
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Cobrar', 'Caja'])]
    public function render()
    {
        return view('livewire.caja.cobrar');
    }
}
