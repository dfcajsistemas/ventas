<?php

namespace App\Livewire\Delivery;

use App\Models\Venta;
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

    #[Title(['Dashboard', 'Delivery'])]
    public function render()
    {
        $paraDelivery = Venta::where('sucursal_id', $this->sucursal->id)
            ->where('est_venta', 2)
            ->count();
        $pedEntregadosHoy = Venta::join('eventas', 'eventas.venta_id', '=', 'ventas.id')
            ->where('ventas.sucursal_id', $this->sucursal->id)
            ->where('eventas.est_venta', 3)
            ->where('eventas.est_anterior', 2)
            ->whereDate('eventas.created_at', now())
            ->count();
        $pedEntregadosMes = Venta::join('eventas', 'eventas.venta_id', '=', 'ventas.id')
            ->where('ventas.sucursal_id', $this->sucursal->id)
            ->where('eventas.est_venta', 3)
            ->where('eventas.est_anterior', 2)
            ->whereMonth('eventas.created_at', now())
            ->count();
        $devueltos = Venta::where('sucursal_id', $this->sucursal->id)
            ->where('est_venta', 5)
            ->count();
        return view('livewire.delivery.dashboard', compact('paraDelivery', 'pedEntregadosHoy', 'pedEntregadosMes', 'devueltos'));
    }
}
