<?php

namespace App\Livewire\Abastecimiento;

use App\Exports\Abastecimiento\ReposicionesExport;
use App\Models\Producto;
use App\Models\Reposicion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Node\Stmt\TryCatch;

#[Lazy()]
class Reposiciones extends Component
{
    use WithPagination;

    public $cantidad, $lote, $observaciones, $created_at, $mMethod, $mTitle;

    public $sucursal, $producto, $stock;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '')]
    public $desde = '';
    #[Url(except: '')]
    public $hasta = '';
    #[Url(except: '10')]
    public $perPage = '10';

    public function mount(Producto $producto)
    {
        $this->sucursal = Auth::user()->sucursal;
        $this->producto = $producto;
        $this->stock = $producto->stocks->where('sucursal_id', $this->sucursal->id)->first();
        $this->desde = now()->subMonths(2)->format('Y-m-d');
        $this->hasta = now()->format('Y-m-d');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Title(['Reposiciones', 'Abastecimiento'])]
    public function render()
    {
        $reposiciones = Reposicion::where('sucursal_id', $this->sucursal->id)
            ->where('producto_id', $this->producto->id)
            ->whereBetween('created_at', [$this->desde, $this->hasta])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.abastecimiento.reposiciones', compact('reposiciones'));
    }

    public function create()
    {
        $this->mMethod = 'store';
        $this->mTitle = 'Nueva Reposición';
        $this->resetValidation();
        $this->reset(['cantidad', 'lote', 'observaciones']);
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'cantidad' => 'required|numeric',
            'lote' => 'required',
            'observaciones' => 'nullable|max:255'
        ], [
            'cantidad.required' => 'La cantidad es obligatoria',
            'cantidad.numeric' => 'La cantidad debe ser un número',
            'lote.required' => 'El lote es obligatorio',
            'observaciones.max' => 'Máximo 255 caracteres'
        ]);

        $this->stock->stock += $this->cantidad;
        DB::beginTransaction();
        try {
            Reposicion::create([
                'cantidad' => $this->cantidad,
                'lote' => $this->lote,
                'observaciones' => $this->observaciones,
                'producto_id' => $this->producto->id,
                'sucursal_id' => $this->sucursal->id,
                'created_by' => Auth::id()
            ]);
            $this->stock->save();
            DB::commit();
            $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Reposición registrada']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('hm', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
        }
    }
    #[On('delete')]
    public function destroy(Reposicion $reposicion)
    {
        $ns = $this->stock->stock - $reposicion->cantidad;
        if ($ns < 0) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Stock no puede ser negativo, verifique']);
            return;
        } else {
            DB::beginTransaction();
            try {
                $this->stock->stock = $ns;
                $this->stock->save();
                $reposicion->delete();
                DB::commit();
                $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Reposición eliminada']);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
            }
        }
    }

    public function details(Reposicion $reposicion)
    {
        $this->mTitle = 'Detalles de Reposición';
        $this->cantidad = $reposicion->cantidad;
        $this->lote = $reposicion->lote;
        $this->observaciones = $reposicion->observaciones;
        $this->created_at = $reposicion->created_at;
        $this->dispatch('smd');
    }

    public function export()
    {
        return (new ReposicionesExport($this->producto->nombre, $this->producto->id, $this->desde, $this->hasta, $this->sucursal))->download('reposiciones_' . date('dmYHis') . '.xlsx');
    }
}
