<?php

namespace App\Livewire\Reportes;

use App\Models\Dventa;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class DetalleVenta extends Component
{
    public $sucursal, $venta, $cliente;

    public function mount(Venta $venta)
    {
        $this->venta = $venta;
        $this->sucursal = $this->venta->sucursal;
        $this->cliente = $this->venta->cliente;
    }

    #[Title(['Detealle de la venta', 'Reportes'])]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();
        $eventas = $this->venta->eventas;
        return view('livewire.reportes.detalle-venta', compact('productos', 'eventas'));
    }
}
