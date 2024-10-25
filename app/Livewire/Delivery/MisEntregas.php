<?php

namespace App\Livewire\Delivery;

use App\Models\Eventa;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Lazy()]
class MisEntregas extends Component
{
    public $sucursal;
    #[Url()]
    public $fecha;
    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';

    public function mount()
    {
        $this->sucursal = auth()->user()->sucursal;
        $this->fecha = now()->format('Y-m-d');
    }
    #[Title(['Mis entregas', 'Delivery'])]
    public function render()
    {
        $pedidos = Eventa::join('ventas', 'eventas.venta_id', '=', 'ventas.id')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.id', 'eventas.created_at', 'eventas.est_venta', 'ventas.est_pago', 'clientes.razon_social')
            ->whereDate('eventas.created_at', $this->fecha)
            ->where('eventas.est_venta', 3)
            ->where(function ($query) {
                $query->where('clientes.razon_social', 'like', '%' . $this->search . '%')
                    ->orWhere('ventas.id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('ventas.id', 'DESC')
            ->paginate($this->perPage);
        return view('livewire.delivery.mis-entregas', compact('pedidos'));
    }
}
