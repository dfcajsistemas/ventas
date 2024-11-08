<?php

namespace App\Livewire\Despacho;

use App\Models\Sucursal;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Dashboard extends Component
{
    public $sucursal;

    public function mount()
    {
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Dashboard', 'Despacho'])]
    public function render()
    {
        $enproceso = $this->sucursal->ventas()->whereNull('est_venta')->count();
        $solicitados = $this->sucursal->ventas()->where('est_venta', 1)->count();
        $deliverys = $this->sucursal->ventas()->where('est_venta', 2)->count();
        $devueltos = $this->sucursal->ventas()->where('est_venta', 5)->count();
        return view('livewire.despacho.dashboard', compact('enproceso', 'solicitados', 'deliverys', 'devueltos'));
    }
}
