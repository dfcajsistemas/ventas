<?php

namespace App\Livewire\Reportes;

use App\Exports\Reportes\CuentasCobrarExport;
use App\Models\Sucursal;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy()]
class CuentasCobrar extends Component
{
    use WithPagination;

    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';
    #[Url()]
    public $sucursal;
    public $sucursales;

    public function mount()
    {
        $this->sucursales = Sucursal::where('estado', 1)->pluck('nombre', 'id');
        $this->sucursal = Sucursal::where('estado', 1)->first()->id;
    }

    #[Title(['Cuentas por cobrar', 'Reportes'])]
    public function render()
    {
        $ventas = Venta::join('clientes', 'ventas.cliente_id', 'clientes.id')
            ->select('ventas.*', 'clientes.razon_social')
            ->where('sucursal_id', $this->sucursal)
            ->where('est_pago', 1)
            ->whereIn('est_venta', [1, 2, 3, 5])
            ->where('clientes.razon_social', 'like', '%' . $this->search . '%')
            ->orderBy('ventas.id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.reportes.cuentas-cobrar', compact('ventas'));
    }

    public function export()
    {
        return (new CuentasCobrarExport($this->search, $this->sucursal))->download('cuentas-cobrar_' . date('dmYHis') . '.xlsx');
    }
}
