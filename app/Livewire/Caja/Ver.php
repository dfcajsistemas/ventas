<?php

namespace App\Livewire\Caja;

use App\Models\Caja;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Ver extends Component
{
    use WithPagination;

    public $sucursal, $caja;

    #[Url(except: '')]
    public $search='';
    #[Url(except: '10')]
    public $perPage='10';
    #[Url(except: '10')]
    public $perPagePagos='10';
    #[Url(except: '10')]
    public $perPageMovimientos='10';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function mount(Caja $caja){
        $this->sucursal = auth()->user()->sucursal;
        $this->caja = $caja;
    }

    #[Title(['Ver Caja', 'Caja'])]
    public function render()
    {
        $ventas=Venta::join('clientes','ventas.cliente_id','=','clientes.id')
                ->where(function($query){
                    $query->where('clientes.razon_social','like',"%$this->search%")
                        ->where('ventas.sucursal_id',$this->sucursal->id)
                        ->where('ventas.est_pago', 1);
                })
                ->select('ventas.id','ventas.created_at','clientes.razon_social as cliente')
                ->paginate($this->perPage);
        $pagos=Pago::where('caja_id',$this->caja->id)->paginate($this->perPagePagos, pageName: 'pagePagos');
        $movimientos=Movimiento::where('caja_id',$this->caja->id)->paginate($this->perPageMovimientos, pageName: 'pageMovimientos');
        //obtener el total de pagos por caja y por nombre de mpago
        $totalPagos=Pago::where('caja_id',$this->caja->id)->selectRaw('mpago_id, sum(monto) as total')
            ->groupBy('mpago_id')
            ->get();
        return view('livewire.caja.ver', compact('ventas','pagos','movimientos', 'totalPagos'));
    }
}
