<?php

namespace App\Livewire\Despacho;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    #[Title(['Dashboard', 'Despacho'])]
    public function render()
    {
        return view('livewire.despacho.dashboard');
    }
}
