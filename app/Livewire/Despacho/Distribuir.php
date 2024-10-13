<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Distribuir extends Component
{
    public $venta, $sucursal;
    public $correo, $telefono, $direccion, $referencia, $mMethod, $mTitle, $idm;

    public function mount(Venta $venta)
    {
        $this->venta = $venta;
        $this->sucursal = auth()->user()->sucursal;
    }

    #[Title(['Distribuir', 'Despacho'])]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();
        $cliente = $this->venta->cliente;
        return view('livewire.despacho.distribuir', compact('cliente', 'productos'));
    }
    public function eDatosCliente()
    {
        $this->mTitle = 'Editar datos cliente';
        $this->mMethod = 'uDatosCliente';
        $cliente = $this->venta->cliente;
        $this->correo = $cliente->correo;
        $this->telefono = $cliente->telefono;
        $this->direccion = $cliente->direccion;
        $this->referencia = $cliente->referencia;
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function uDatosCliente()
    {
        $this->validate([
            'correo' => 'nullable|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'referencia' => 'nullable',
        ], [
            'correo.email' => 'El correo no es válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'direccion.required' => 'La dirección es obligatoria'
        ]);
        $cliente = $this->venta->cliente;
        $cliente->update([
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'referencia' => $this->referencia,
        ]);
        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Datos actualizados']);
    }
    #[On('entregar')]
    public function entregar()
    {
        $this->venta->update([
            'est_venta' => 3,
            'fentrega' => now(),
            'updated_by' => auth()->id(),
        ]);
        $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Se registró la entrega del pedido']);
    }
    #[On('delivery')]
    public function delivery()
    {
        $this->venta->update([
            'est_venta' => 2,
            'fdelivery' => now(),
            'updated_by' => auth()->id(),
        ]);
        $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Se registró el pedido para delivery']);
    }

    #[On('anular')]
    public function anular()
    {
        try {
            DB::beginTransaction();
            $this->venta->update([
                'est_venta' => 4,
                'fanulado' => now(),
                'updated_by' => auth()->id(),
            ]);

            foreach ($this->venta->dventas as $dventa) {
                $stock = $dventa->producto->stocks->where('sucursal_id', $this->sucursal->id)->first();
                $stock->update([
                    'stock' => $stock->stock + $dventa->cantidad,
                ]);
            }
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Se anuló el pedido']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Hubo un error al anular el pedido']);
        }
    }
}
