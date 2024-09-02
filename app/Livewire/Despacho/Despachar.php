<?php

namespace App\Livewire\Despacho;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Despachar extends Component
{
    #[Title(['Despachar', 'Despacho'])]
    public function render()
    {
        return view('livewire.despacho.despachar');
    }
}
