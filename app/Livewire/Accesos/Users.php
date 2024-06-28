<?php

namespace App\Livewire\Accesos;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $password, $rpassword, $mevent, $mtitle, $idm, $nombre;
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
        $users= User::select('id', 'name', 'surname', 'doc_numero', 'estado')
                    ->where('name', 'LIKE', "%$this->search%")
                    ->orWhere('surname', 'LIKE', "%$this->search%")
                    ->orWhere('doc_numero', 'LIKE', "%$this->search%")
                    ->where('estado', 1)
                    ->orderBy('surname')
                    ->orderBy('name')
                    ->paginate($this->perPage);
        return view('livewire.accesos.users', compact('users'))
                ->layoutData(['modulo'=>'Accesos', 'pagina'=>'Personal']);
    }

    public function create()
    {
        $this->mtitle = 'Cambiar contraseña';
        $this->mevent = 'password';
        $this->resetInputFields();
        $this->openModal();
    }

    
}
