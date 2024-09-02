<?php

namespace App\Livewire\Abastecimiento;

use App\Models\Stock;
use App\Models\Sucursal;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Dashboard extends Component
{
    use WithPagination;

    public $sucursal;

    public function mount(){
        $this->sucursal=Sucursal::find(auth()->user()->sucursal_id);
    }

    #[Title(['Dashboard', 'Abastecimiento'])]
    public function render()
    {
        $stocks=Stock::where('sucursal_id', $this->sucursal->id)->whereRaw('stock <= stock_minimo + ?', [5])->paginate(10);
        return view('livewire.abastecimiento.dashboard', compact('stocks'));
    }
}
