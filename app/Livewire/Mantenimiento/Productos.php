<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Categoria;
use App\Models\Igvafectacion;
use App\Models\Igvporciento;
use App\Models\Producto;
use App\Models\Umedida;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Productos extends Component
{
    use WithPagination;

    public $nombre, $codigo, $descripcion, $icbper, $umedida_id, $categoria_id, $igvafectacion_id, $igvporciento_id, $mMethod, $mTitle, $idm;

    public $umedidas, $igvafectacions, $categorias, $igvporcientos;

    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    public function mount(){
        $this->umedidas=Umedida::where('estado', 1)->pluck('descripcion', 'id');
        $this->igvafectacions=Igvafectacion::where('estado', 1)->pluck('descripcion', 'id');
        $this->categorias=Categoria::where('estado', 1)->pluck('nombre', 'id');
        $this->igvporcientos=Igvporciento::where('estado', 1)->pluck('porcentaje', 'id');
    }

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
        $this->reset(['nombre', 'codigo', 'descripcion', 'icbper', 'umedida_id', 'categoria_id', 'igvafectacion_id', 'igvporciento_id']);
        $this->resetValidation();
        $this->dispatch('sm');
    }
}
