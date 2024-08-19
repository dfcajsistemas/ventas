<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Mpago;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Mpagos extends Component
{
    use WithPagination;

    public $nombre, $mMethod, $mTitle, $idm;

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

    #[Title(['Métodos de Pago', 'Mantenimiento'])]
    public function render()
    {
        $mpagos = Mpago::where('nombre', 'LIKE', "%" . $this->search . "%")
            ->orderBy('nombre')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.mpagos', compact('mpagos'));
    }

    public function create()
    {
        $this->mMethod = 'store';
        $this->mTitle = 'Nuevo Modo de Pago';
        $this->reset(['nombre']);
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|unique:mpagos,nombre',
        ], [
            'nombre.required' => 'Ingrese el nombre del método de pago',
            'nombre.unique' => 'El método de pago ya existe',
        ]);

        Mpago::create([
            'nombre' => $this->nombre,
            'updated_by' => auth()->id(),
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Modo de pago registrado.']);
    }

    public function edit(Mpago $mpago)
    {
        $this->mMethod = 'update';
        $this->mTitle = 'Editar Modo de Pago';
        $this->resetValidation();
        $this->nombre = $mpago->nombre;
        $this->idm = $mpago->id;
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|unique:mpagos,nombre,' . $this->idm,
        ], [
            'nombre.required' => 'Ingrese el nombre del método de pago',
            'nombre.unique' => 'El método de pago ya existe',
        ]);

        Mpago::find($this->idm)->update([
            'nombre' => $this->nombre,
            'updated_by' => auth()->id(),
        ]);

        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Modo de pago editado']);
    }

    public function status(Mpago $mpago)
    {
        $mpago->update([
            'estado' => $mpago->estado ? null : 1,
            'updated_by' => auth()->id(),
        ]);
        $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Se cambio el estado del modo de pago.']);
    }

    #[On('delete')]
    public function destroy(Mpago $mpago)
    {
        if ($mpago->pagos->count()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>El modo de pago tiene pagos registrados']);
            return;
        } else {
            $mpago->delete();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Modo de pago eliminado']);
        }
    }
}
