<?php

namespace App\Exports\Reportes;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CuentasCobrarExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $search, $sucursal;

    public function __construct($search, $sucursal)
    {
        $this->search = $search;
        $this->sucursal = $sucursal;
    }

    public function view(): View
    {
        $ventas = Venta::join('clientes', 'ventas.cliente_id', 'clientes.id')
            ->select('ventas.*', 'clientes.razon_social')
            ->where('sucursal_id', $this->sucursal)
            ->where('est_pago', 1)
            ->whereIn('est_venta', [1, 2, 3, 5])
            ->where('clientes.razon_social', 'like', '%' . $this->search . '%')
            ->orderBy('ventas.id', 'desc')
            ->get();

        return view('reportes.cuentas-cobrar-export', ['ventas' => $ventas]);
    }
}
