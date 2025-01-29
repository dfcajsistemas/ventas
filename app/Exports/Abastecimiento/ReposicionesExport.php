<?php

namespace App\Exports\Abastecimiento;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReposicionesExport implements FromView, ShouldAutoSize
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
        return view('abastecimiento.reposiciones-export');
    }
}
