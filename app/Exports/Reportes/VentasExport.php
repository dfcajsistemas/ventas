<?php

namespace App\Exports\Reportes;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VentasExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $desde, $hasta, $estado, $sucursal;

    public function __construct($desde, $hasta, $estado, $sucursal)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->estado = $estado;
        $this->sucursal = $sucursal;
    }

    public function view(): View
    {
        //dd($this->desde, $this->hasta, $this->estado);
        if ($this->estado == '') {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->where('sucursal_id', $this->sucursal)
                ->whereDate('created_at', '<=', $this->hasta)
                ->whereNotNull('est_venta')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->where('sucursal_id', $this->sucursal)
                ->whereDate('created_at', '<=', $this->hasta)
                ->where('est_venta', $this->estado)
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('reportes.ventas-export', ['ventas' => $ventas]);
    }
}
