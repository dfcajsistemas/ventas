<?php

namespace App\Exports\Reportes;

use App\Models\Caja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FlujoCajasExport implements FromView, ShouldAutoSize
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
        $cajas = Caja::join('users', 'cajas.user_id', '=', 'users.id')
            ->join('sucursals', 'cajas.sucursal_id', '=', 'sucursals.id')
            ->select('cajas.id', 'cajas.apertura', 'cajas.cierre', 'users.name as usuario', 'cajas.monto_cierre', 'sucursals.nombre as sucursal')
            ->where('cajas.sucursal_id', $this->sucursal)
            ->whereBetween('cajas.apertura', [$this->desde . ' 00:00:00', $this->hasta . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('users.name', 'like', "%$this->search%");
            })
            ->get();
        return view('reportes.flujo-cajas-export', compact('cajas'));
    }
}
