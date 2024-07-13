<?php

namespace App\Livewire\Accesos;

use App\Models\Sucursal;
use App\Models\Tdocumento;
use App\Models\User;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Nette\Utils\Random;

#[Lazy()]
class Users extends Component
{
    use WithPagination;

    public $name, $tdocumento_id, $ndocumento, $fec_nac, $email, $password, $sucursal_id, $mMethod, $mTitle, $idm, $kb;
    public $tdocumentos, $sucursales;
    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount(){
        $this->tdocumentos = Tdocumento::where('estado', 1)->pluck('abreviatura', 'id');
        $this->sucursales = Sucursal::where('estado', 1)->pluck('nombre', 'id');
    }

    #[Title(['Usuarios', 'Accesos'])]
    public function render()
    {
        $users= User::select('id', 'name', 'tdocumento_id', 'ndocumento', 'estado', 'sucursal_id')
                    ->where('name', 'LIKE', "%$this->search%")
                    ->orWhere('ndocumento', 'LIKE', "%$this->search%")
                    ->where('estado', 1)
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.users', compact('users'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVO USUARIO';
        $this->mMethod = 'store';
        $this->reset(['name', 'tdocumento_id', 'ndocumento', 'fec_nac', 'email', 'password', 'sucursal_id']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'tdocumento_id' => 'required',
            'ndocumento' => 'required|unique:users,ndocumento',
            'fec_nac' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'sucursal_id' => 'required'
        ],
        [
            'name.required' => 'Nombre obligatorio',
            'tdocumento_id.required' => 'Tipo de Documento obligatorio',
            'ndocumento.required' => '# Documento obligatorio',
            'ndocumento.unique' => '# Documento existe',
            'fec_nac.required' => 'Fec. Nacimiento obligatoria',
            'fec_nac.date' => 'Fec. Nacimiento no válida',
            'email.required' => 'Email obligatorio',
            'email.email' => 'Email no válido',
            'email.unique' => 'Email existe',
            'sucursal_id.required' => 'Sucursal obligatoria'
        ]);

        $pass=Random::generate(8);

        User::create([
            'name' => $this->name,
            'tdocumento_id' => $this->tdocumento_id,
            'ndocumento' => $this->ndocumento,
            'fec_nac' => $this->fec_nac,
            'email' => $this->email,
            'password' => bcrypt($pass),
            'sucursal_id' => $this->sucursal_id,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);

        $this->dispatch('hm', ['m' => '¡Hecho!<br>Usuario creado. Contraseña: '.$pass, 't' => 'success']);
    }

    public function edit(User $user)
    {
        $this->mTitle = 'EDITAR USUARIO';
        $this->mMethod = 'update';
        $this->idm = $user->id;
        $this->name = $user->name;
        $this->tdocumento_id = $user->tdocumento_id;
        $this->ndocumento = $user->ndocumento;
        $this->fec_nac = $user->fec_nac;
        $this->email = $user->email;
        $this->sucursal_id = $user->sucursal_id;
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function update(){
        $this->validate([
            'name' => 'required',
            'tdocumento_id' => 'required',
            'ndocumento' => 'required|unique:users,ndocumento,'.$this->idm,
            'fec_nac' => 'required|date',
            'email' => 'required|email|unique:users,email,'.$this->idm,
            'sucursal_id' => 'required'
        ],
        [
            'name.required' => 'El Nombre es obligatorio',
            'tdocumento_id.required' => 'Tipo de Documento obligatorio',
            'ndocumento.required' => '# Documento obligatorio',
            'ndocumento.unique' => '# Documento existe',
            'fec_nac.required' => 'Fec. Nacimiento obligatoria',
            'fec_nac.date' => 'Fec. Nacimiento no válida',
            'email.required' => 'Email obligatorio',
            'email.email' => 'Email no válido',
            'email.unique' => 'Email existe',
            'sucursal_id.required' => 'Sucursal es obligatoria'
        ]);

        $user = User::find($this->idm);
        $user->name = $this->name;
        $user->tdocumento_id = $this->tdocumento_id;
        $user->ndocumento = $this->ndocumento;
        $user->fec_nac = $this->fec_nac;
        $user->email = $this->email;
        $user->sucursal_id = $this->sucursal_id;
        $user->updated_by = auth()->user()->id;
        $user->save();
        $this->dispatch('hm', ['m' => '¡Hecho!<br>Usuario actualizado', 't' => 'success']);
    }

    public function estado(User $user)
    {
        $user->estado = $user->estado ? 0 : 1;
        $user->save();
        $this->dispatch('hm', ['m' => '¡Hecho!<br>Se cambio el estado de '.$user->name, 't' => 'success']);
    }

    public function editPassword(User $user)
    {
        $this->mTitle = 'CAMBIAR CONTRASEÑA';
        $this->mMethod = 'updateForm';
        $this->idm = $user->id;
        $this->name = $user->name;
        $this->kb = rand(1, 99);
        $this->reset(['password']);
        $this->resetValidation();
        $this->dispatch('sp');
    }

    public function updateForm(){
        $this->validate([
            'password' => 'required|min:8'
        ],
        [
            'password.required' => 'Contraseña obligatoria',
            'password.min' => 'Mínimo 8 caracteres'
        ]);

        $user = User::find($this->idm);
        $user->password = bcrypt($this->password);
        $user->updated_by = auth()->user()->id;
        $user->save();
        $this->dispatch('hp', ['m' => '¡Hecho!<br>Contraseña cambiada', 't' => 'success']);
    }


}
