<?php

namespace App\Livewire\Reportes;

use App\Models\Sucursal;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class VentaProductos extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $desde;
    #[Url(except: '')]
    public $hasta;
    #[Url(except: '')]
    public $sucursal;
    public $sucursales;

    public function mount()
    {
        $this->sucursales = Sucursal::where('estado', 1)->pluck('nombre', 'id');
        $this->sucursal = Sucursal::where('estado', 1)->first()->id;
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedDesde()
    {
        $this->resetPage();
    }

    public function updatedHasta()
    {
        $this->resetPage();
    }

    public function updatedSucursal()
    {
        $this->resetPage();
    }

    #[Title(['Venta de productos', 'Reportes'])]
    public function render()
    {
        $productos = Venta::join('dventas', 'ventas.id', '=', 'dventas.venta_id')
            ->join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->join('sucursals', 'ventas.sucursal_id', '=', 'sucursals.id')
            ->where(function ($query) {
                $query->where('productos.nombre', 'like', "%$this->search%")
                    ->where('ventas.sucursal_id', $this->sucursal)
                    ->whereIn('ventas.est_venta', [1, 2, 3, 5])
                    ->whereBetween('ventas.created_at', [$this->desde . ' 00:00:00', $this->hasta . ' 23:59:59']);
            })
            ->select('productos.nombre', 'sucursals.nombre as sucursal', 'dventas.cantidad', 'dventas.precio', 'dventas.total', 'ventas.created_at', 'ventas.id')
            ->orderBy('ventas.id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.reportes.venta-productos', compact('productos'));
    }
}
