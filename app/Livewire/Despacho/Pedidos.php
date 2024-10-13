<?php

namespace App\Livewire\Despacho;

use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Pedidos extends Component
{
    use WithPagination;

    public $sucursal;

    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Pedidos', 'Despacho'])]
    public function render()
    {
        $pedidos = Venta::join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('ventas.id', 'ventas.created_at', 'ventas.est_venta', 'ventas.est_pago', 'clientes.razon_social')
            ->where('ventas.sucursal_id', $this->sucursal->id)
            ->where('clientes.razon_social', 'like', '%' . $this->search . '%')
            ->orWhere('ventas.id', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        return view('livewire.despacho.pedidos', compact('pedidos'));
    }

    public function create()
    {
        $venta = Venta::create([
            'user_id' => auth()->id(),
            'sucursal_id' => auth()->user()->sucursal->id,
            'tmoneda_id' => 1,
            'cliente_id' => 1,
            'est_venta' => 1,
            'est_pago' => 1,
        ]);

        return redirect()->route('despacho.pedidos.canasta', $venta);
    }

    #[On('delete')]
    public function destroy(Venta $venta)
    {
        if ($venta->dventas()->count() > 0) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se puede eliminar el pedido porque tiene productos.']);
        } else {
            $venta->delete();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Pedido eliminado.']);
        }
    }
}
