<?php

namespace App\Livewire\Reportes;

use App\Exports\Reportes\VentasExport;
use App\Models\Sucursal;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy()]
class Ventas extends Component
{
    use WithPagination;
    #[Url(except: '')]
    public $estado = '';
    #[Url(except: '10')]
    public $perPage = '10';
    #[Url()]
    public $desde;
    #[Url()]
    public $hasta;
    #[Url()]
    public $sucursal;
    public $sucursales;

    public function mount()
    {
        $this->desde = now()->format('Y-m-d');
        $this->hasta = now()->format('Y-m-d');
        $this->sucursales = Sucursal::where('estado', 1)->pluck('nombre', 'id');
        $this->sucursal = Sucursal::where('estado', 1)->first()->id;
    }

    #[Title(['Ventas', 'Reportes'])]
    public function render()
    {

        if ($this->estado == '') {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->where('sucursal_id', $this->sucursal)
                ->whereDate('created_at', '<=', $this->hasta)
                ->whereNotNull('est_venta')
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);
        } else {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->where('sucursal_id', $this->sucursal)
                ->whereDate('created_at', '<=', $this->hasta)
                ->where('est_venta', $this->estado)
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);
        }

        return view('livewire.reportes.ventas', compact('ventas'));
    }

    public function export()
    {
        //return Excel::download(new VentasExport($this->desde, $this->hasta, $this->estado), 'ventas_' . date('dmYHis') . '.xlsx');
        //dd($this->desde, $this->hasta, $this->estado);
        return (new VentasExport($this->desde, $this->hasta, $this->estado, $this->sucursal))->download('ventas_' . date('dmYHis') . '.xlsx');
    }
}
