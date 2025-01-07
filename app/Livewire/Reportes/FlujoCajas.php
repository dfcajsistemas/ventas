<?php

namespace App\Livewire\Reportes;

use App\Exports\Reportes\FlujoCajasExport;
use App\Models\Caja;
use App\Models\Sucursal;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class FlujoCajas extends Component
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

    #[Title(['Flujo de cajas', 'Reportes'])]
    public function render()
    {
        $cajas = Caja::join('users', 'cajas.user_id', '=', 'users.id')
            ->join('sucursals', 'cajas.sucursal_id', '=', 'sucursals.id')
            ->select('cajas.id', 'cajas.apertura', 'cajas.cierre', 'users.name as usuario', 'cajas.monto_cierre', 'sucursals.nombre as sucursal')
            ->where('cajas.sucursal_id', $this->sucursal)
            ->whereBetween('cajas.apertura', [$this->desde . ' 00:00:00', $this->hasta . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('users.name', 'like', "%$this->search%");
            })
            ->paginate($this->perPage);
        return view('livewire.reportes.flujo-cajas', compact('cajas'));
    }

    public function export()
    {
        return (new FlujoCajasExport($this->desde, $this->hasta, $this->sucursal, $this->search))->download('flujo-cajas_' . date('dmYHis') . '.xlsx');
    }
}
