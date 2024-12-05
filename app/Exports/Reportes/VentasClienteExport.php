<?php

namespace App\Exports\Reportes;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VentasClienteExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $desde, $hasta, $sucursal, $estado, $search, $perPage;

    public function __construct($desde, $hasta, $sucursal, $estado, $search, $perPage)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->sucursal = $sucursal;
        $this->estado = $estado;
        $this->search = $search;
        $this->perPage = $perPage;
    }

    public function view(): View
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
        return view('reportes.ventas-cliente-export', compact('ventas'));
    }
}
