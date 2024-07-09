<?php

namespace App\Livewire\Accesos;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;

    public $name, $mMethod, $mTitle, $idm, $kb;
    public $perPage = '10';
    public $search = '';

    public function render()
    {
        $roles=Role::where('name', 'LIKE', "%$this->search%")
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.roles', compact('roles'))
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Roles']);;
    }

    public function create()
    {
        $this->mTitle = 'NUEVO ROL';
        $this->mMethod = 'store';
        $this->kb = rand(1, 99);
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
        $this->kb = rand(1, 99);
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
