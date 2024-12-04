<?php

namespace App\Livewire\Delivery;

use App\Models\Dventa;
use App\Models\Empresa;
use App\Models\Eventa;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Entregar extends Component
{
    public $sucursal, $venta, $cliente;
    public function mount(Venta $venta)
    {
        $this->venta = $venta;
        if ($venta->est_venta != 2) {
            return redirect()->route('delivery.pedidos');
        }
        $this->sucursal = auth()->user()->sucursal;
        $this->cliente = $this->venta->cliente;
    }

    #[Title(['Entregar', 'Delivery'])]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();
        $eventas = $this->venta->eventas;
        return view('livewire.delivery.entregar', compact('productos', 'eventas'));
    }

    #[On('entregar')]
    public function entregar()
    {
        try {
            DB::beginTransaction();
            $this->venta->eventas()->create([
                'user_id' => auth()->id(),
                'est_venta' => 3,
                'est_anterior' => $this->venta->est_venta,
            ]);
            $this->venta->update([
                'est_venta' => 3,
            ]);
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Entrega registrada']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Hubo un error al registrar la entrega del pedido']);
        }
    }

    #[On('devolver')]
    public function devolver()
    {
        try {
            DB::beginTransaction();
            $this->venta->eventas()->create([
                'user_id' => auth()->id(),
                'est_venta' => 5,
                'est_anterior' => $this->venta->est_venta,
            ]);
            $this->venta->update([
                'est_venta' => 5,
            ]);
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Devolución registrada']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>Hubo un error al registrar la devolución del pedido']);
        }
    }

    public function ticket()
    {
        //Datos de la empresa
        $empresa = Empresa::first();
        //Usuario que genero el despacho
        $eventa = Eventa::where('venta_id', $this->venta->id)
            ->where('est_venta', 1)
            ->first();

        $ancho = 226.77; // 80mm en puntos
        $alto_por_fila = 22; // Altura estimada por fila en puntos
        $numero_filas = $this->venta->dventas()->count();
        $alto = 210 + $alto_por_fila * $numero_filas;
        $pdf = Pdf::loadView('despacho.ticket', ['venta' => $this->venta, 'empresa' => $empresa, 'user' => $eventa->user->name])
            ->setPaper([0, 0, $ancho, $alto]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $this->venta->id . '.pdf');
    }
}
