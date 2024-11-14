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

    private $desde, $hasta, $estado;

    public function __construct($desde, $hasta, $estado)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->estado = $estado;
    }

    public function view(): View
    {
        if ($this->estado == '') {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->whereDate('created_at', '<=', $this->hasta)
                ->whereNotNull('est_venta')
                ->orderBy('id', 'desc');
        } else {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->whereDate('created_at', '<=', $this->hasta)
                ->where('est_venta', $this->estado)
                ->orderBy('id', 'desc');
        }
        return view('reportes.ventas-export', ['ventas' => $ventas]);
    }
}
