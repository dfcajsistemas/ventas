<?php

namespace App\Exports\Reportes;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DespachosExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $desde, $hasta, $sucursal, $search;

    public function __construct($desde, $hasta, $sucursal, $search)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->sucursal = $sucursal;
        $this->search = $search;
    }

    public function view(): View
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
            ->get();
        return view('reportes.despachos-export', compact('ventas'));
    }
}
