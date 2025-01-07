<?php

namespace App\Exports\Reportes;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VentaProductosExport implements FromView, ShouldAutoSize
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
        $productos = Venta::join('dventas', 'ventas.id', '=', 'dventas.venta_id')
            ->join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->join('sucursals', 'ventas.sucursal_id', '=', 'sucursals.id')
            ->where(function ($query) {
                $query->where('productos.nombre', 'like', "%$this->search%")
                    ->where('ventas.sucursal_id', $this->sucursal)
                    ->whereIn('ventas.est_venta', [1, 2, 3, 5])
                    ->whereBetween('ventas.created_at', [$this->desde . ' 00:00:00', $this->hasta . ' 23:59:59']);
            })
            ->select('productos.nombre', 'sucursals.nombre as sucursal', 'dventas.cantidad', 'dventas.precio', 'dventas.total', 'ventas.created_at', 'ventas.id')
            ->orderBy('ventas.id', 'desc')
            ->get();

        return view('reportes.venta-productos-export', compact('productos'));
    }
}
