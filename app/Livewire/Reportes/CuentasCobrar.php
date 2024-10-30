<?php

namespace App\Livewire\Reportes;

use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class CuentasCobrar extends Component
{
    use WithPagination;

    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    #[Title(['Cuentas por cobrar', 'Reportes'])]
    public function render()
    {
        $ventas = Venta::join('clientes', 'ventas.cliente_id', 'clientes.id')
            ->where('est_pago', 1)
            ->whereNotNull('est_venta')
            ->where('est_venta', '<>', 4)
            ->where('clientes.razon_social', 'like', '%' . $this->search . '%')
            ->orderBy('ventas.id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.reportes.cuentas-cobrar', compact('ventas'));
    }
}
