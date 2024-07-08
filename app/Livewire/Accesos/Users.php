<?php

namespace App\Livewire\Accesos;

use App\Models\Sucursal;
use App\Models\Tdocumento;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $name, $tdocumento_id, $ndocumento, $fec_nac, $email, $password, $cpassword, $sucursal_id, $mMethod, $mTitle, $idm;
    public $tdocumentos, $sucursales;
    public $perPage = '10';
    public $search = '';
    public $isOpen=0;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => '10']
    ];

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount(){
        $this->tdocumentos = Tdocumento::where('estado', 1)->pluck('abreviatura', 'id');
        $this->sucursales = Sucursal::where('estado', 1)->pluck('nombre', 'id');
    }

    public function render()
    {
        $users= User::select('id', 'name', 'tdocumento_id', 'ndocumento', 'estado', 'sucursal_id')
                    ->where('name', 'LIKE', "%$this->search%")
                    ->orWhere('ndocumento', 'LIKE', "%$this->search%")
                    ->where('estado', 1)
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.users', compact('users'))
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Personal']);
    }

    public function create()
    {
        $this->mTitle = 'NUEVO USUARIO';
        $this->mMethod = 'store';
        $this->reset(['name', 'tdocumento_id', 'ndocumento', 'fec_nac', 'email', 'password', 'cpassword', 'sucursal_id']);
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
            'password' => 'required|min:8|same:cpassword',
            'sucursal_id' => 'required'
        ],
        [
            'name.required' => 'El Nombre es obligatorio',
            'tdocumento_id.required' => 'El Tipo de Documento es obligatorio',
            'ndocumento.required' => 'El # Documento es obligatorio',
            'ndocumento.unique' => 'El # Documento existe',
            'fec_nac.required' => 'La Fec. Nacimiento es obligatoria',
            'fec_nac.date' => 'El Fec. Nacimiento no es válida',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email existe',
            'password.required' => 'La Contraseña es obligatoria',
            'password.min' => 'Mínimo 8 caracteres',
            'password.same' => 'Las contraseñas no coinciden',
            'sucursal_id.required' => 'La Sucursal es obligatoria'
        ]);

        //dd($this->ndocumento);

        User::create([
            'name' => $this->name,
            'tdocumento_id' => $this->tdocumento_id,
            'ndocumento' => $this->ndocumento,
            'fec_nac' => $this->fec_nac,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'sucursal_id' => $this->sucursal_id,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);

        $this->dispatch('hm', ['m' => 'Usuario creado', 't' => 'success']);
    }

    public function estado(User $user)
    {
        $user->estado = $user->estado ? 0 : 1;
        $user->save();
        $this->dispatch('hm', ['m' => '¡Hecho!<br>Se cambio el estado de '.$user->name, 't' => 'success']);
    }


}
