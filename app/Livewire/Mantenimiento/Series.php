<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Serie;
use App\Models\Sucursal;
use App\Models\Tcomprobante;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Series extends Component
{
    use WithPagination;

    public $serie, $tcomprobante_id, $sucursal_id, $mMethod, $mTitle, $idm;

    public $tcomprobantes, $sucursals;

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

    public function mount()
    {
        $this->tcomprobantes = Tcomprobante::where('estado', 1)->pluck('descripcion', 'id');
        $this->sucursals = Sucursal::where('estado', 1)->pluck('nombre', 'id');
    }

    #[Title(['Series', 'Mantenimiento'])]
    public function render()
    {
        $series = Serie::where('serie', 'LIKE', "%" . $this->search . "%")
            ->orderBy('serie')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.series', compact('series'));
    }

    public function create()
    {
        $this->mMethod = 'store';
        $this->mTitle = 'Nueva Serie';
        $this->reset(['serie', 'tcomprobante_id', 'sucursal_id']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'serie' => 'required|unique:series,serie',
            'tcomprobante_id' => 'required',
            'sucursal_id' => 'required',
        ], [
            'serie.required' => 'Ingrese la serie',
            'serie.unique' => 'La serie ya existe',
            'tcomprobante_id.required' => 'Seleccione el tipo de comprobante',
            'sucursal_id.required' => 'Seleccione la sucursal',
        ]);

        if (strlen($this->serie) != 4) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La serie debe tener 4 caracteres']);
            return;
        } elseif (Serie::where('tcomprobante_id', $this->tcomprobante_id)->where('sucursal_id', $this->sucursal_id)->exists()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La sucursal ya tiene una serie registrada para este tipo de comprobante.']);
            return;
        } else {
            Serie::create([
                'serie' => $this->serie,
                'tcomprobante_id' => $this->tcomprobante_id,
                'sucursal_id' => $this->sucursal_id,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);

            $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Serie registrada.']);
        }
    }

    public function edit(Serie $serie)
    {
        $this->mMethod = 'update';
        $this->mTitle = 'Editar Serie';
        $this->resetValidation();
        $this->serie = $serie->serie;
        $this->tcomprobante_id = $serie->tcomprobante_id;
        $this->sucursal_id = $serie->sucursal_id;
        $this->idm = $serie->id;
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'serie' => 'required|unique:series,serie,' . $this->idm,
            'tcomprobante_id' => 'required',
            'sucursal_id' => 'required',
        ], [
            'serie.required' => 'Ingrese la serie',
            'serie.unique' => 'La serie ya existe',
            'tcomprobante_id.required' => 'Seleccione el tipo de comprobante',
            'sucursal_id.required' => 'Seleccione la sucursal',
        ]);

        if (strlen($this->serie) != 4) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La serie debe tener 4 caracteres']);
            return;
        } elseif (Serie::where('tcomprobante_id', $this->tcomprobante_id)->where('sucursal_id', $this->sucursal_id)->where('id', '!=', $this->idm)->exists()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La sucursal ya tiene una serie registrada para este tipo de comprobante.']);
            return;
        } else {
            Serie::find($this->idm)->update([
                'serie' => $this->serie,
                'tcomprobante_id' => $this->tcomprobante_id,
                'sucursal_id' => $this->sucursal_id,
                'updated_by' => auth()->id(),
            ]);

            $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Serie actualizada.']);
        }
    }
}
