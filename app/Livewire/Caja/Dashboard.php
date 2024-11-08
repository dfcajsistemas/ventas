<?php

namespace App\Livewire\Caja;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    public $sucursal;

    public function mount()
    {
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Dashboard', 'Caja'])]
    public function render()
    {
        $cajasAbiertas = $this->sucursal->cajas()->whereNull('cierre')->count();
        return view('livewire.caja.dashboard', compact('cajasAbiertas'));
    }
}
