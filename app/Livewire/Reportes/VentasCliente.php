<?php

namespace App\Livewire\Reportes;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title(['Ventas por cliente', 'Reportes'])]
class VentasCliente extends Component
{
    #[Title(['Ventas por cliente', 'Reportes'])]
    public function render()
    {
        return view('livewire.reportes.ventas-cliente');
    }
}
