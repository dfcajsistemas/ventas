<?php

namespace App\Livewire\Accesos;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

#[Lazy()]
class Permisos extends Component
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

    #[Title(['Permisos', 'Accesos'])]
    public function render()
    {
        $permisos=Permission::where('name', 'LIKE', "%".$this->search."%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.permisos', compact('permisos'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVO PERMISO';
        $this->mMethod = 'store';
        $this->reset(['name']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El permiso ya existe',
        ]);

        Permission::create([
            'name' => $this->name,
        ]);

        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso registrado']);
    }

    public function edit($id)
    {
        $this->mTitle = 'EDITAR PERMISO';
        $this->mMethod = 'update';
        $permiso = Permission::find($id);
        $this->idm = $permiso->id;
        $this->name = $permiso->name;
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name,'.$this->idm,
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El permiso ya existe',
        ]);

        $permiso = Permission::find($this->idm);
        $permiso->update([
            'name' => $this->name,
        ]);

        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso actualizado']);
    }

    #[On('delete')]
    public function destroy($id)
    {
        Permission::destroy($id);
        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Permiso eliminado']);
    }
}
