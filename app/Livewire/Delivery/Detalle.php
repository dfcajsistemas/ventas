<?php

namespace App\Livewire\Delivery;

use App\Models\Dventa;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Detalle extends Component
{
    public $sucursal, $venta, $cliente;

    public function mount(Venta $venta)
    {
        $this->venta = $venta;
        $this->sucursal = auth()->user()->sucursal;
        $this->cliente = $this->venta->cliente;
    }

    #[Title(['Detalle de entrega', 'Delivery'])]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();
        $eventas = $this->venta->eventas;
        return view('livewire.delivery.detalle', compact('productos', 'eventas'));
    }
}
