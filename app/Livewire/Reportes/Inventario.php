<?php

namespace App\Livewire\Reportes;

use App\Exports\Reportes\InventarioExport;
use App\Models\Producto;
use App\Models\Sucursal;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Inventario extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';
    public $sucursal;
    public $sucursales;

    public function mount()
    {
        $this->sucursales = Sucursal::where('estado', 1)->pluck('nombre', 'id');
        $this->sucursal = Sucursal::where('estado', 1)->first()->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSucursal()
    {
        $this->resetPage();
    }

    #[Title(['Inventario', 'Reportes'])]
    public function render()
    {
        $productos = Producto::join('stocks', 'productos.id', '=', 'stocks.producto_id')
            ->join('sucursals', 'stocks.sucursal_id', '=', 'sucursals.id')
            ->select('productos.id', 'productos.nombre', 'p_costo', 'p_venta1', 'p_venta2', 'p_venta3', 'stocks.stock', 'stocks.stock_minimo', 'sucursals.nombre as sucursal')
            ->where('stocks.sucursal_id', $this->sucursal)
            ->where('productos.nombre', 'LIKE', "%$this->search%")
            ->orderBy('productos.nombre')
            ->paginate($this->perPage);
        return view('livewire.reportes.inventario', compact('productos'));
    }

    public function export()
    {
        return (new InventarioExport($this->sucursal, $this->search))->download('inventario_' . date('dmYHis') . '.xlsx');
    }
}
