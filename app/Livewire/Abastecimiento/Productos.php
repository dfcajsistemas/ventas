<?php

namespace App\Livewire\Abastecimiento;

use App\Models\Producto;
use App\Models\Stock;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Productos extends Component
{
    use WithPagination;

    public $stock_minimo, $idm, $idp, $mTitle, $mMethod;
    public $sucursal;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sucursal = Auth()->user()->sucursal;
    }

    #[Title(['Productos', 'Abastecimiento'])]
    public function render()
    {
        $productos = Producto::where('nombre', 'LIKE', "%" . $this->search . "%")
            ->where('estado', 1)
            ->orderBy('nombre')
            ->paginate($this->perPage);
        return view('livewire.abastecimiento.productos', compact('productos'));
    }

    public function stock(Producto $producto)
    {
        $this->mTitle = 'Stock de ' . $producto->nombre;
        $this->mMethod = 'ustock';
        $this->idp = $producto->id;
        if ($s = $producto->stocks->where('sucursal_id', $this->sucursal->id)->first()) {
            $this->stock_minimo = $s->stock_minimo;
            $this->idm = $s->id;
        } else {
            $this->reset('stock_minimo');
        }
        $this->dispatch('sm');
    }
    public function ustock()
    {
        $this->validate([
            'stock_minimo' => 'required|numeric|min:5'
        ], [
            'stock_minimo.required' => 'El stock minimo es requerido',
            'stock_minimo.numeric' => 'El stock minimo debe ser un número',
            'stock_minimo.min' => 'El stock minimo debe ser mayor a 5'
        ]);
        if ($this->idm) {
            $stock = Stock::find($this->idm);
        } else {
            $stock = new Stock();
            $stock->producto_id = $this->idp;
            $stock->sucursal_id = $this->sucursal->id;
            $stock->created_by = Auth()->user()->id;
        }
        $stock->stock_minimo = $this->stock_minimo;
        $stock->updated_by = Auth()->user()->id;

        $stock->save();

        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Stock mínimo actualizado']);
    }
}
