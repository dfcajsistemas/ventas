<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Cproductos extends Component
{
    public $cantidad, $mTitle, $mMethod, $idm;
    public $venta_id;
    public function mount($venta_id)
    {
        $this->venta_id = $venta_id;
    }
    #[On('rep')]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('dventas.id', 'productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.igv', 'dventas.total')
            ->where('dventas.venta_id', $this->venta_id)
            ->get();
        return view('livewire.despacho.cproductos', compact('productos'));
    }

    public function ecantidad($id)
    {
        $this->mTitle = 'Editar Cantidad';
        $this->mMethod = 'gcantidad';
        $this->idm = $id;
        $this->cantidad = Dventa::find($id)->cantidad;
        $this->resetValidation();
        $this->dispatch('smca');
    }
    public function gcantidad()
    {
        $this->validate([
            'cantidad' => 'required|numeric|min:1',
        ], [
            'cantidad.required' => 'Ingrese la cantidad',
            'cantidad.numeric' => 'La cantidad debe ser un número',
            'cantidad.min' => 'La cantidad debe ser mayor a 0',
        ]);
        $dventa = Dventa::find($this->idm);

        $stock = $dventa->producto->stocks->where('sucursal_id', auth()->user()->sucursal->id)->first();
        $nc = $this->cantidad - $dventa->cantidad;
        if ($stock->stock < $nc) {
            $this->dispatch('hmca', ['t' => 'error', 'm' => '¡Error!<br>Stock insuficiente']);
            return;
        }

        $p = $dventa->precio;
        $t = $p * $this->cantidad;
        if ($dventa->producto->igvafectacion_id == 1) {
            $igv = $t * 0.18;
        } else {
            $igv = 0;
        }

        try {
            DB::beginTransaction();
            $stock->update([
                'stock' => $stock->stock - $nc,
                'updated_by' => auth()->user()->id
            ]);

            $dventa->update([
                'cantidad' => $this->cantidad,
                'total' => $t,
                'igv' => $igv,
                'updated_by' => auth()->user()->id
            ]);
            DB::commit();
            $this->dispatch('hmca', ['t' => 'success', 'm' => '¡Hecho!<br>Cantidad actualizada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('hmca', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
        }
    }

    #[On('delete')]
    public function delete(Dventa $dventa)
    {
        $stock = $dventa->producto->stocks->where('sucursal_id', auth()->user()->sucursal->id)->first();

        try {
            DB::beginTransaction();
            $stock->update([
                'stock' => $stock->stock + $dventa->cantidad,
                'updated_by' => auth()->user()->id
            ]);
            $dventa->delete();
            DB::commit();
            $this->dispatch('reca', ['t' => 'success', 'm' => '¡Hecho!<br>Producto eliminado de la canasta']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('reca', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
        }
    }
}
