<?php

namespace App\Livewire\Delivery;

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

    #[Title(['Dashboard', 'Delivery'])]
    public function render()
    {
        return view('livewire.delivery.dashboard');
    }
}
