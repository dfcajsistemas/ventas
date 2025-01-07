<?php

namespace App\Livewire\Reportes;

use App\Exports\Reportes\DespachosExport;
use App\Models\Sucursal;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Despachos extends Component
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingDesde()
    {
        $this->resetPage();
    }

    public function updatingHasta()
    {
        $this->resetPage();
    }

    public function updatingSucursal()
    {
        $this->resetPage();
    }

    #[Title(['Despachos por responsable', 'Reportes'])]
    public function render()
    {
        $ventas = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->join('sucursals', 'ventas.sucursal_id', '=', 'sucursals.id')
            ->join('users', 'ventas.user_id', '=', 'users.id')
            ->join('eventas', 'ventas.id', '=', 'eventas.venta_id')
            ->select('ventas.id', 'eventas.created_at', 'clientes.razon_social', 'ventas.fpago', 'ventas.est_venta', 'ventas.est_pago', 'ventas.total', 'ventas.est_venta', 'sucursals.nombre as sucursal', 'users.name as responsable')
            ->where('ventas.sucursal_id', $this->sucursal)
            ->whereNotNull('ventas.est_venta')
            ->where(function ($query) {
                $query->where('users.name', 'LIKE', "%$this->search%")
                    ->where('eventas.est_venta', 1)
                    ->whereBetween('ventas.created_at', [$this->desde . ' 00:00:00', $this->hasta . ' 23:59:59']);
            })
            ->orderBy('ventas.id')
            ->paginate($this->perPage);

        return view('livewire.reportes.despachos', compact('ventas'));
    }

    public function export()
    {
        return (new DespachosExport($this->desde, $this->hasta, $this->sucursal, $this->search))->download('despachos_' . date('dmYHis') . '.xlsx');
    }
}
