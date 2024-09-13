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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    #[Title(['Pedidos', 'Despacho'])]
    public function render()
    {
        $pedidos = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.*', 'clientes.razon_social')
            ->where('ventas.sucursal_id', auth()->user()->sucursal->id)
            ->where('clientes.razon_social', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        return view('livewire.despacho.pedidos', compact('pedidos'));
    }

    public function create(){
        $venta=Venta::create([
            'user_id'=>auth()->id(),
            'sucursal_id'=>auth()->user()->sucursal->id,
            'tmoneda_id'=>1,
            'cliente_id'=>1
        ]);

        return redirect()->route('despacho.pedidos.canasta',$venta);
    }
}
