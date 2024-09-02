<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Serie;
use App\Models\Sucursal;
use App\Models\Tcomprobante;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Series extends Component
{
    use WithPagination;

    public $serie, $tcomprobante_id, $prefijo, $correlativo, $sucursal_id, $mMethod, $mTitle, $idm;

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

    public function updatedTcomprobanteId($value)
    {
        $this->prefijo = Tcomprobante::find($value)->prefijo;
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
            'serie' => 'required|min:3|max:3',
            'tcomprobante_id' => 'required',
            'sucursal_id' => 'required'
        ], [
            'serie.required' => 'Ingrese la serie',
            'serie.min' => 'Ingrese 3 caracteres',
            'serie.max' => 'Ingrese 3 caracteres',
            'tcomprobante_id.required' => 'Elije el tipo de comprobante',
            'sucursal_id.required' => 'Elije la sucursal'
        ]);

        if (Serie::where('tcomprobante_id', $this->tcomprobante_id)->where('sucursal_id', $this->sucursal_id)->where('estado', 1)->exists()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La sucursal ya tiene una serie activa para este tipo de comprobante.']);
            return;
        } elseif(Serie::where('serie', $this->prefijo.$this->serie)->exists()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La serie ingresada ya existe.']);
            return;
        }

        else {
            Serie::create([
                'serie' => $this->prefijo.$this->serie,
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
        $this->serie = substr($serie->serie, 1, 3);
        $this->prefijo = substr($serie->serie, 0, 1);
        $this->tcomprobante_id = $serie->tcomprobante_id;
        $this->sucursal_id = $serie->sucursal_id;
        $this->idm = $serie->id;
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'serie' => 'required|min:3|max:3',
            'tcomprobante_id' => 'required',
            'sucursal_id' => 'required',
        ], [
            'serie.required' => 'Ingrese la serie',
            'serie.min' => 'Ingrese 3 caracteres',
            'serie.max' => 'Ingrese 3 caracteres',
            'serie.unique' => 'La serie ya existe',
            'tcomprobante_id.required' => 'Elija el tipo de comprobante',
            'sucursal_id.required' => 'Elija la sucursal',
        ]);

        if (Serie::where('tcomprobante_id', $this->tcomprobante_id)->where('sucursal_id', $this->sucursal_id)->where('id', '!=', $this->idm)->exists()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La sucursal ya tiene una serie registrada para este tipo de comprobante.']);
            return;
        }elseif(Serie::where('serie', $this->prefijo.$this->serie)->where('id', '!=', $this->idm)->exists()){
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La serie ingresada ya existe.']);
            return;
        } else {
            Serie::find($this->idm)->update([
                'serie' => $this->prefijo.$this->serie,
                'tcomprobante_id' => $this->tcomprobante_id,
                'sucursal_id' => $this->sucursal_id,
                'updated_by' => auth()->id(),
            ]);

            $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Serie actualizada.']);
        }
    }

    public function status(Serie $serie)
    {
        if(!$serie->estado){
            if(Serie::where('tcomprobante_id', $serie->tcomprobante_id)->where('sucursal_id', $serie->sucursal_id)->where('estado', 1)->exists()){
                $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La sucursal ya tiene una serie activa para este tipo de comprobante.']);
                return;
            }else{
                $serie->update([
                    'estado' => 1,
                    'updated_by' => auth()->id()
                ]);
                $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Serie activada']);
                return;
            }
        }else{
            $serie->update([
                'estado' => null,
                'updated_by' => auth()->id()
            ]);
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Serie desactivada']);
            return;
        }
    }
    #[On('delete')]
    public function destroy(Serie $serie)
    {
        //dd($serie);
        if($serie->correlativo > 0){
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se puede eliminar, ya se emitió comprobantes con la serie.']);
            return;
        }else{
            $serie->delete();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Serie eliminada']);
        }
    }
}
