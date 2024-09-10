<?php

namespace App\Livewire\Delivery;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    #[Title(['Dashboard', 'Delivery'])]
    public function render()
    {
        return view('livewire.delivery.dashboard');
    }
}
