<?php

namespace App\Livewire\Delivery;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Pedidos extends Component
{
    #[Title(['Pedidos', 'Delivery'])]
    public function render()
    {
        return view('livewire.delivery.pedidos');
    }
}
