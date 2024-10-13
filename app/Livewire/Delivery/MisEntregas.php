<?php

namespace App\Livewire\Delivery;

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
        $pedidos = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.id', 'ventas.created_at', 'ventas.est_venta', 'ventas.est_pago', 'clientes.razon_social')
            ->where('ventas.est_venta', 3)
            ->whereDate('ventas.fentrega', $this->fecha)
            ->where('ventas.updated_by', auth()->id())
            ->where(function ($query) {
                $query->where('clientes.razon_social', 'like', '%' . $this->search . '%')
                    ->orWhere('ventas.id', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);
        return view('livewire.delivery.mis-entregas', compact('pedidos'));
    }
}
