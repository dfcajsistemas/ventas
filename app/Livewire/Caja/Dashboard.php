<?php

namespace App\Livewire\Caja;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    #[Title(['Dashboard', 'Caja'])]
    public function render()
    {
        return view('livewire.caja.dashboard');
    }
}
