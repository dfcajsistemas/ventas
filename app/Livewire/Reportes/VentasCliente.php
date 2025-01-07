<?php

namespace App\Livewire\Reportes;

use App\Exports\Reportes\VentasClienteExport;
use App\Models\Sucursal;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class VentasCliente extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $estado = '';
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

    public function updatingEstado()
    {
        $this->resetPage();
    }

    #[Title(['Ventas por cliente', 'Reportes'])]
    public function render()
    {
        if ($this->estado == '') {
            $ventas = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
                ->join('sucursals', 'ventas.sucursal_id', '=', 'sucursals.id')
                ->select('ventas.id', 'ventas.created_at', 'clientes.razon_social', 'ventas.fpago', 'ventas.est_venta', 'ventas.est_pago', 'ventas.total', 'ventas.est_venta', 'sucursals.nombre as sucursal')
                ->where('ventas.sucursal_id', $this->sucursal)
                ->whereNotNull('ventas.est_venta')
                ->whereDate('ventas.created_at', '>=', $this->desde)
                ->whereDate('ventas.created_at', '<=', $this->hasta)
                ->where(function ($query) {
                    $query->where('clientes.razon_social', 'LIKE', "%$this->search%");
                })
                ->orderBy('clientes.razon_social')
                ->paginate($this->perPage);
        } else {
            $ventas = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
                ->join('sucursals', 'ventas.sucursal_id', '=', 'sucursals.id')
                ->select('ventas.id', 'ventas.created_at', 'clientes.razon_social', 'ventas.fpago', 'ventas.est_venta', 'ventas.est_pago', 'ventas.total', 'ventas.est_venta', 'sucursals.nombre as sucursal')
                ->where('ventas.sucursal_id', $this->sucursal)
                ->where('ventas.est_venta', $this->estado)
                ->whereDate('ventas.created_at', '>=', $this->desde)
                ->whereDate('ventas.created_at', '<=', $this->hasta)
                ->where(function ($query) {
                    $query->where('clientes.razon_social', 'LIKE', "%$this->search%");
                })
                ->orderBy('clientes.razon_social')
                ->paginate($this->perPage);
        }
        return view('livewire.reportes.ventas-cliente', compact('ventas'));
    }

    public function export()
    {
        return (new VentasClienteExport($this->desde, $this->hasta, $this->sucursal, $this->estado, $this->search))->download('ventas-cliente_' . date('dmYHis') . '.xlsx');
    }
}
