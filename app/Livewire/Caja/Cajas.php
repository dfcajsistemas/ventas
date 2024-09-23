<?php

namespace App\Livewire\Caja;

use App\Models\Caja;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Cajas extends Component
{
    use WithPagination;

    public $mMethod, $mTitle, $sucursal;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function mount(){
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Cajas', 'Caja'])]
    public function render()
    {
        $cajas = Caja::join('users', 'cajas.user_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users.name', 'like', "%$this->search%")
                    ->where('cajas.sucursal_id', $this->sucursal->id);
            })
            ->select('cajas.id', 'cajas.apertura', 'cajas.cierre','users.name')
            ->paginate($this->perPage);
        return view('livewire.caja.cajas', compact('cajas'));
    }
    public function create()
    {
        $this->mTitle = 'Aperturar caja';
        $this->mMethod = 'store';

        $this->dispatch('sm');
    }
    public function store()
    {
        $existe = Caja::where('user_id', auth()->user()->id)->where('cierre', null)->exists();
        if ($existe) {
            $this->dispatch('hm', ['t' => 'error', 'm' => '¡Error!<br>Ya tiene una caja aperturada']);
            return;
        }
        Caja::create([
            'apertura' => NOW(),
            'user_id' => auth()->id(),
            'sucursal_id' => auth()->user()->sucursal_id,
        ]);

        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Caja aperturada']);
    }
    #[On('delete')]
    public function destroy(Caja $caja)
    {
        if ($caja->cierre) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Caja cerrada']);
            return;
        }elseif ($caja->user_id != auth()->id()) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No puede cerrar una caja que no es suya']);
            return;
        }elseif ($caja->movimientos->count() > 0) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La caja tiene movimientos']);
            return;
        }elseif($caja->pagos->count() > 0){
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La caja tiene pagos']);
            return;
        }else{
            $caja->delete();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Caja eliminada']);
        }
    }

}
