<?php

namespace App\Livewire\Accesos;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $password, $rpassword, $mMethod, $mTitle, $idm, $nombre;
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

    public function render()
    {
        $users= User::select('id', 'name', 'doc_numero', 'estado')
                    ->where('name', 'LIKE', "%$this->search%")
                    ->orWhere('doc_numero', 'LIKE', "%$this->search%")
                    ->where('estado', 1)
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.users', compact('users'))
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Personal']);
    }

    public function create()
    {
        $this->mTitle = 'Nuevo usuario';
        $this->mMethod = 'store';
        $this->dispatch('sm');
    }

    public function store()
    {
        // $this->validate([
        //     'nombre' => 'required',
        //     'password' => 'required|min:8',
        //     'rpassword' => 'required|same:password'
        // ]);

        // User::create([
        //     'name' => $this->nombre,
        //     'password' => bcrypt($this->password)
        // ]);

        $this->dispatch('hm', ['m' => 'Usuario creado', 't' => 'success']);
    }


}
