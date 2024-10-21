<?php

namespace App\Livewire\Delivery;

use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Pedidos extends Component
{
    use WithPagination;

    public $sucursal;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Pedidos', 'Delivery'])]
    public function render()
    {
        $pedidos = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.id', 'ventas.created_at', 'ventas.est_venta', 'ventas.est_pago', 'clientes.razon_social')
            ->where('ventas.sucursal_id', $this->sucursal->id)
            ->where('ventas.est_venta', 2)
            ->where(function ($query) {
                $query->where('clientes.razon_social', 'like', '%' . $this->search . '%')
                    ->orWhere('ventas.id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('ventas.id', 'desc')
            ->paginate($this->perPage);
        return view('livewire.delivery.pedidos', compact('pedidos'));
    }
}
