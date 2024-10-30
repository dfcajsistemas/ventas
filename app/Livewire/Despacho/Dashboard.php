<?php

namespace App\Livewire\Despacho;

use App\Models\Sucursal;
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

    #[Title(['Dashboard', 'Despacho'])]
    public function render()
    {
        return view('livewire.despacho.dashboard');
    }
}
