<?php

namespace App\Livewire\Despacho;

use App\Models\Producto;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Despachar extends Component
{
    use WithPagination;

    public $sucursal;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '20')]
    public $perPage = 20;

    public function mount()
    {
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Despachar', 'Despacho'])]
    public function render()
    {
        $productos = Producto::join('stocks', 'productos.id', '=', 'stocks.producto_id')
            ->select('productos.id','productos.nombre', 'productos.p_venta'.$this->sucursal->p_venta, 'stocks.stock')
            ->where('productos.nombre', 'LIKE', "%" . $this->search . "%")
            ->where('stocks.sucursal_id', $this->sucursal->id)
            ->where('stocks.stock', '>', 0)
            ->paginate($this->perPage);
        return view('livewire.despacho.despachar', compact('productos'));
    }

    public function add(Producto $producto)
    {
        dd($producto);
    }
}
