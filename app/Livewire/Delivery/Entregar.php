<?php

namespace App\Livewire\Delivery;

use App\Models\Dventa;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Entregar extends Component
{
    public $sucursal, $venta, $cliente;
    public function mount(Venta $venta)
    {
        $this->venta = $venta;
        if ($venta->est_venta != 2) {
            return redirect()->route('delivery.pedidos');
        }
        $this->sucursal = auth()->user()->sucursal;
        $this->cliente = $this->venta->cliente;
    }

    #[Title(['Entregar', 'Delivery'])]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();
        return view('livewire.delivery.entregar', compact('productos'));
    }

    #[On('entregar')]
    public function entregar()
    {
        $this->venta->update([
            'est_venta' => 3,
            'fentrega' => now(),
            'updated_by' => auth()->id(),
        ]);
        $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Se registró la entrega del pedido']);
    }
}
