<?php

namespace App\Livewire\Accesos;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Lazy()]
class Roles extends Component
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

    #[Title(['Roles', 'Accesos'])]
    public function render()
    {
        $roles=Role::where('name', 'LIKE', "%".$this->search."%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.roles', compact('roles'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVO ROL';
        $this->mMethod = 'store';
        $this->reset(['name']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El rol ya existe',
        ]);

        Role::create([
            'name' => $this->name,
        ]);

        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Rol registrado']);
    }

    public function edit($id)
    {
        $this->mTitle = 'EDITAR ROL';
        $this->mMethod = 'update';
        $rol = Role::find($id);
        $this->idm = $rol->id;
        $this->name = $rol->name;
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,'.$this->idm,
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El rol ya existe',
        ]);

        $rol = Role::find($this->idm);
        $rol->update([
            'name' => $this->name,
        ]);

        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Rol actualizado']);
    }

    #[On('delete')]
    public function destroy($id)
    {
        Role::destroy($id);
        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Rol eliminado']);
    }
}
