<?php

namespace App\Exports\Reportes;

use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventarioExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $sucursal, $search;

    public function __construct($sucursal, $search)
    {
        $this->sucursal = $sucursal;
        $this->search = $search;
    }

    public function view(): View
    {
        $productos = Producto::join('stocks', 'productos.id', '=', 'stocks.producto_id')
            ->join('sucursals', 'stocks.sucursal_id', '=', 'sucursals.id')
            ->select('productos.id', 'productos.nombre', 'p_costo', 'p_venta1', 'p_venta2', 'p_venta3', 'stocks.stock', 'stocks.stock_minimo', 'sucursals.nombre as sucursal')
            ->where('stocks.sucursal_id', $this->sucursal)
            ->where('productos.nombre', 'LIKE', "%$this->search%")
            ->orderBy('productos.nombre')
            ->get();
        return view('reportes.inventario-export', compact('productos'));
    }
}
