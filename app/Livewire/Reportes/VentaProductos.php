<?php

namespace App\Livewire\Reportes;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class VentaProductos extends Component
{
    #[Title(['Venta de productos', 'Reportes'])]
    public function render()
    {
        return view('livewire.reportes.venta-productos');
    }
}
