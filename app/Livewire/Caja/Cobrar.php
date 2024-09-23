<?php

namespace App\Livewire\Caja;

use App\Models\Caja;
use App\Models\Cuota;
use App\Models\Dventa;
use App\Models\Mpago;
use App\Models\Pago;
use App\Models\Tcomprobante;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

#[Lazy()]
class Cobrar extends Component
{
    public $mTitle, $mMethod, $idm, $precio, $monto, $mpago, $mrecibido, $observacion, $tcomprobante;
    public $caja, $venta, $sucursal, $mpagos, $tcomprobantes, $mtotal, $mpagado;
    public $cuotas;

    public function mount(Caja $caja, Venta $venta)
    {
        $this->caja = $caja;
        $this->venta = $venta;
        $this->sucursal = auth()->user()->sucursal;
        $this->tcomprobantes = Tcomprobante::join('series', 'tcomprobantes.id', '=', 'series.tcomprobante_id')
            ->where('series.sucursal_id', $this->sucursal->id)
            ->pluck('tcomprobantes.descripcion', 'tcomprobantes.id');
        $this->mpagos = Mpago::where('estado', 1)->pluck('nombre', 'id');
    }

    #[Title(['Cobrar Venta', 'Caja'])]
    public function render()
    {
        $this->mtotal = Dventa::where('venta_id', $this->venta->id)->sum('total');
        $this->mpagado = Pago::where('venta_id', $this->venta->id)->sum('monto');

        $pagos = Pago::where('venta_id', $this->venta->id)->get();
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('dventas.id', 'productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.igv', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();

        return view('livewire.caja.cobrar', compact('pagos', 'productos'));
    }

    public function eprecio(Dventa $dventa)
    {
        $this->mTitle = 'Editar Precio';
        $this->mMethod = 'gprecio';
        $this->idm = $dventa->id;
        $this->precio = $dventa->precio;
        $this->dispatch('smp');
    }

    public function gprecio()
    {
        $this->validate([
            'precio' => 'required|numeric|min:1',
        ], [
            'precio.required' => 'Ingrese el precio',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio debe ser mayor a 0',
        ]);
        $dventa = Dventa::find($this->idm);
        $t = $this->precio * $dventa->cantidad;
        $igv = $t * 0.18;
        $dventa->update([
            'precio' => $this->precio,
            'total' => $t,
            'igv' => $igv,
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('hmp', ['t' => 'success', 'm' => '¡Hecho!<br>Precio cambiado correctamente']);
    }

    public function ncobrar()
    {
        //calcular el monto total
        $mt=Dventa::where('venta_id', $this->venta->id)->sum('total');
        //calcular el monto pagado
        $mp=Pago::where('venta_id', $this->venta->id)->sum('monto');

        $this->mTitle = 'Cobrar';
        $this->mMethod = 'gcobrar';
        $this->reset(['mpago', 'mrecibido', 'observacion']);
        $this->monto = $mt - $mp;
        $this->dispatch('smc');
    }

    public function gcobrar()
    {
        //calcular el monto total
        $mt=Dventa::where('venta_id', $this->venta->id)->sum('total');
        //calcular el monto pagado
        $mp=Pago::where('venta_id', $this->venta->id)->sum('monto');

        if (($mp + $this->monto) > $mt) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>El monto a pagar es mayor al total de la venta']);
            return;
        }
        $this->validate([
            'monto' => 'required|numeric|min:1',
            'mpago' => 'required',
            'mrecibido' => 'nullable|numeric|min:' . $this->monto. '|required_if:mpago,1',
        ], [
            'monto.required' => 'Ingrese el monto',
            'monto.numeric' => 'El monto debe ser un número',
            'monto.min' => 'El monto debe ser mayor a 0',
            'mpago.required' => 'Seleccione el medio de pago',
            'mrecibido.required_if' => 'Ingrese el monto recibido',
            'mrecibido.numeric' => 'El monto recibido debe ser un número',
            'mrecibido.min' => 'El monto recibido debe ser mayor al monto a pagar',
        ]);
        $cambio = $this->mrecibido - $this->monto;
        $pago = Pago::create([
            'venta_id' => $this->venta->id,
            'mpago_id' => $this->mpago,
            'caja_id' => $this->caja->id,
            'monto' => $this->monto,
            'observacion' => $this->observacion,
            'created_by' => auth()->user()->id
        ]);
        if (($mp + $this->monto) == $mt) {
            $this->venta->update([
                'est_pago' => null,
                'updated_by' => auth()->user()->id
            ]);
        }

        $this->dispatch('hmc', ['t' => 'success', 'm' => '¡Hecho!<br>Venta cobrada correctamente']);
    }

    public function acredito()
    {
        $this->mTitle = 'A Crédito';
        $this->mMethod = 'gcredito';
        $this->reset(['cuotas']);
        $this->dispatch('smcre');
    }

    public function gcredito()
    {
        $this->validate([
            'cuotas' => 'required|numeric|min:1',
        ], [
            'cuotas.required' => 'Ingrese el número de cuotas',
            'cuotas.numeric' => 'El número de cuotas debe ser un número',
            'cuotas.min' => 'El número de cuotas debe ser mayor a 0',
        ]);
        $this->venta->update([
            'fpago' => 1,
            'updated_by' => auth()->user()->id
        ]);

        for ($i = 1; $i <= $this->cuotas; $i++) {
            $cuota = round($this->mtotal / $this->cuotas, 2);
            Cuota::create([
                'venta_id' => $this->venta->id,
                'numero' => $i,
                'monto' => $cuota,
                'fvence' => date('Y-m-d', strtotime('+' . $i . ' month'))
            ]);
        }

        $this->dispatch('hmcre', ['t' => 'success', 'm' => '¡Hecho!<br>Venta a crédito registrada correctamente']);
    }
    public function acontado()
    {
        if ($this->venta->pagos()->count() > 0) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La venta tiene pagos registrados']);
            return;
        }
        $this->venta->update([
            'fpago' => null,
            'updated_by' => auth()->user()->id
        ]);
        //eliminar las cuotas de la venta
        Cuota::where('venta_id', $this->venta->id)->delete();
        $this->dispatch('hmcre', ['t' => 'success', 'm' => '¡Hecho!<br>Se cambio la venta a contado']);
    }

    //metodo emitir que permita solicitar el tipo de comprobante en una modal
    public function emitir()
    {
        $this->mTitle = 'Emitir Comprobante';
        $this->mMethod = 'gemitir';
        $this->reset(['tcomprobante']);
        $this->dispatch('smemi');
    }

    #[On('delete')]
    public function destroyPago(Pago $pago)
    {
        DB::beginTransaction();
        try {
            $pago->delete();
            $this->venta->update([
                'est_pago' => 1,
                'updated_by' => auth()->user()->id
            ]);
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Pago eliminado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo eliminar el pago. '.$e->getMessage()]);
        }
    }

    public function gemitir()
    {
        $this->validate([
            'tcomprobante' => 'required',
        ], [
            'tcomprobante.required' => 'Seleccione el tipo de comprobante',
        ]);
        $this->venta->update([
            'tcomprobante_id' => $this->tcomprobante,
            'updated_by' => auth()->user()->id
        ]);

        $this->dispatch('hmemi', ['t' => 'success', 'm' => '¡Hecho!<br>Comprobante emitido correctamente']);
    }

    public function emitirpdf()
    {
        $pdf = Pdf::loadView('pdf.comprobante', ['venta' => $this->venta]);
        return $pdf->stream('comprobante.pdf');
    }
}
