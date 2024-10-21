<?php

namespace App\Livewire\Reportes;

use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Ventas extends Component
{
    use WithPagination;

    public $estado = '';
    public $perPage = '10';
    public $desde;
    public $hasta;

    public function mount()
    {
        $this->desde = now()->format('Y-m-d');
        $this->hasta = now()->format('Y-m-d');
    }

    #[Title(['Ventas', 'Reportes'])]
    public function render()
    {

        if ($this->estado == '') {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->whereDate('created_at', '<=', $this->hasta)
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);
        } else {
            $ventas = Venta::whereDate('created_at', '>=', $this->desde)
                ->whereDate('created_at', '<=', $this->hasta)
                ->where('est_venta', $this->estado)
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);
        }

        return view('livewire.reportes.ventas', compact('ventas'));
    }
}
