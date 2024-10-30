<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Mpago;
use App\Models\Producto;
use App\Models\Sucursal;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    #[Title(['Dashboard', 'Mantenimiento'])]
    public function render()
    {
        $empresa = Empresa::first();
        $nsucursales = Sucursal::where('estado', 1)->count();
        $ncategorias = Categoria::where('estado', 1)->count();
        $nproductos = Producto::where('estado', 1)->count();
        $nmpagos = Mpago::where('estado', 1)->count();
        $nclientes = Cliente::where('estado', 1)->count();
        $cumplesMes = Cliente::select('razon_social', 'fnacimiento')->where('estado', 1)->whereMonth('fnacimiento', date('m'))->get();
        return view('livewire.mantenimiento.dashboard', compact('empresa', 'nsucursales', 'ncategorias', 'nproductos', 'nmpagos', 'nclientes', 'cumplesMes'));
    }
}
