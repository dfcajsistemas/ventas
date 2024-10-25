<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Empresa;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $eventas = $this->venta->eventas;
        return view('livewire.despacho.distribuir', compact('cliente', 'productos', 'eventas'));
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
        try {
            DB::beginTransaction();
            $this->venta->update([
                'est_venta' => 3,
            ]);
            $this->venta->eventas()->create([
                'user_id' => auth()->id(),
                'est_venta' => 3,
            ]);
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Entrega registrada']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Hubo un error al registrar la entrega del pedido']);
        }
    }
    #[On('delivery')]
    public function delivery()
    {
        try {
            DB::beginTransaction();
            $this->venta->update([
                'est_venta' => 2,
            ]);
            $this->venta->eventas()->create([
                'user_id' => auth()->id(),
                'est_venta' => 2,
            ]);
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Pedido enviado para delivery']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Hubo un error al enviar para delivery el pedido']);
        }
    }

    #[On('anular')]
    public function anular()
    {
        try {
            DB::beginTransaction();
            $this->venta->update([
                'est_venta' => 4,
                'updated_by' => auth()->id(),
            ]);
            $this->venta->eventas()->create([
                'user_id' => auth()->id(),
                'est_venta' => 4,
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

    public function ticket()
    {
        //Datos de la empresa
        $empresa = Empresa::first();

        $ancho = 226.77; // 80mm en puntos
        $alto_por_fila = 22; // Altura estimada por fila en puntos
        $numero_filas = $this->venta->dventas()->count();
        $alto = 210 + $alto_por_fila * $numero_filas;
        $pdf = Pdf::loadView('despacho.ticket', ['venta' => $this->venta, 'empresa' => $empresa])
            ->setPaper([0, 0, $ancho, $alto]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->venta->id . '.pdf');
    }
}
