<?php

namespace App\Livewire\Reportes;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    #[Title(['Dashboard', 'Reportes'])]
    public function render()
    {
        return view('livewire.reportes.dashboard');
    }
}
