<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Producto;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Productos extends Component
{
    use WithPagination;

    public $name, $mMethod, $mTitle, $idm;
    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Title(['Productos', 'Mantenimiento'])]
    public function render()
    {
        $productos=Producto::select('id', 'nombre', 'codigo', 'estado')
                    ->where('nombre', 'LIKE', "%".$this->search."%")
                    ->orWhere('codigo', 'LIKE', "%".$this->search."%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.mantenimiento.productos', compact('productos'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVO PRODUCTO';
        $this->mMethod = 'store';
        $this->reset(['name']);
        $this->resetValidation();
        $this->dispatch('sm');
    }
}
