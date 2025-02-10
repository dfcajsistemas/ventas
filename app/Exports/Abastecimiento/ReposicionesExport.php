<?php

namespace App\Exports\Abastecimiento;

use App\Models\Reposicion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReposicionesExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $nombre, $producto_id, $desde, $hasta, $sucursal;

    public function __construct($nombre, $producto_id, $desde, $hasta, $sucursal)
    {
        $this->producto_id = $producto_id;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->sucursal = $sucursal;
        $this->nombre = $nombre;
    }

    public function view(): View
    {
        $reposiciones = Reposicion::where('sucursal_id', $this->sucursal->id)
            ->where('producto_id', $this->producto_id)
            ->whereBetween('created_at', [$this->desde, $this->hasta])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('abastecimiento.reposiciones-export', [
            'reposiciones' => $reposiciones,
            'nombre' => $this->nombre,
            'desde' => $this->desde,
            'hasta' => $this->hasta
        ]);
    }
}
