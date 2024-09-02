<?php

namespace App\Livewire\Despacho;

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

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = 10;

    #[Title(['Pedidos', 'Despacho'])]
    public function render()
    {
        $pedidos=Venta::join('clientes','ventas.cliente_id','=','clientes.id')
            ->select('ventas.id','ventas.created_at','ventas.est_venta','clientes.nombre as cliente')
            ->where('ventas.est_venta',1)
            ->where('ventas.sucursal_id',auth()->user()->sucursal->id)
            ->where('clientes.nombre','LIKE',"%$this->search%")
            ->orderBy('ventas.id','desc')
            ->paginate($this->perPage);
        return view('livewire.despacho.pedidos', compact('pedidos'));
    }
}
