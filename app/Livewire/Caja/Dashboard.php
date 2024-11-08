<?php

namespace App\Livewire\Caja;

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

    #[Title(['Dashboard', 'Caja'])]
    public function render()
    {
        $cajasAbiertas = $this->sucursal->cajas()->whereNull('cierre')->count();
        $cobradoHoy = Venta::join('pagos', 'ventas.id', '=', 'pagos.venta_id')
            ->where('ventas.sucursal_id', $this->sucursal->id)
            ->whereDate('pagos.created_at', now())
            ->whereNull('pagos.estado')
            ->sum('pagos.monto');
        $cobradoMes = Venta::join('pagos', 'ventas.id', '=', 'pagos.venta_id')
            ->where('ventas.sucursal_id', $this->sucursal->id)
            ->whereMonth('pagos.created_at', now())
            ->whereNull('pagos.estado')
            ->sum('pagos.monto');
        $pedidosSinPago = Venta::where('sucursal_id', $this->sucursal->id)
            ->where('est_pago', 1)
            ->whereIn('est_venta', [1, 2, 3, 5])
            ->count();
        return view('livewire.caja.dashboard', compact('cajasAbiertas', 'cobradoHoy', 'cobradoMes', 'pedidosSinPago'));
    }
}
