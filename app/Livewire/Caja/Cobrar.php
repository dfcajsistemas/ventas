<?php

namespace App\Livewire\Caja;

use App\Models\Caja;
use App\Models\Cuota;
use App\Models\Dventa;
use App\Models\Mpago;
use App\Models\Pago;
use App\Models\Serie;
use App\Models\Tcomprobante;
use App\Models\Venta;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

#[Lazy()]
class Cobrar extends Component
{
    public $mTitle, $mMethod, $idm, $precio, $monto, $mpago, $mrecibido, $observacion, $tcomprobante, $rComp;
    public $caja, $venta, $sucursal, $mpagos, $tcomprobantes, $mtotal, $mpagado, $mcuotas;
    public $fvence, $mcuota;

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
        //monto total de la venta
        $this->mtotal = Dventa::where('venta_id', $this->venta->id)->sum('total');
        //monto pagado de la venta
        $this->mpagado = Pago::where('venta_id', $this->venta->id)->sum('monto');
        //monto de cuotas de la venta
        $this->mcuotas = Cuota::where('venta_id', $this->venta->id)->sum('monto');
        //obtener los pagos de la venta
        $pagos = Pago::where('venta_id', $this->venta->id)->get();
        //obtener los productos de la venta
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
        $mt = Dventa::where('venta_id', $this->venta->id)->sum('total');
        //calcular el monto pagado
        $mp = Pago::where('venta_id', $this->venta->id)->sum('monto');

        $this->mTitle = 'Cobrar';
        $this->mMethod = 'gcobrar';
        $this->reset(['mpago', 'mrecibido', 'observacion']);
        $this->monto = $this->mtotal - $mp;
        $this->dispatch('smc');
    }

    public function gcobrar()
    {
        //calcular el monto total
        $mt = Dventa::where('venta_id', $this->venta->id)->sum('total');
        //calcular el monto pagado
        $mp = Pago::where('venta_id', $this->venta->id)->sum('monto');

        if (($mp + $this->monto) > $mt) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>El monto a pagar es mayor al total de la venta']);
            return;
        }
        $this->validate([
            'monto' => 'required|numeric|min:1',
            'mpago' => 'required',
            'mrecibido' => 'nullable|numeric|min:' . $this->monto . '|required_if:mpago,1',
        ], [
            'monto.required' => 'Ingrese el monto',
            'monto.numeric' => 'El monto debe ser un número',
            'monto.min' => 'El monto debe ser mayor a 0',
            'mpago.required' => 'Seleccione el medio de pago',
            'mrecibido.required_if' => 'Ingrese el monto recibido',
            'mrecibido.numeric' => 'El monto recibido debe ser un número',
            'mrecibido.min' => 'El monto recibido debe ser mayor al monto a pagar',
        ]);

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
        if ($this->mpago == 1) {
            $cambio = $this->mrecibido - $this->monto;
            $this->dispatch('vu', $cambio);
        }
        $this->dispatch('hmc', ['t' => 'success', 'm' => '¡Hecho!<br>Venta cobrada correctamente']);
    }

    public function acredito()
    {
        $this->mTitle = 'Cuotas';
        $this->mMethod = 'gcredito';
        $this->reset(['fvence', 'mcuota']);
        $this->dispatch('smcre');
        $mt = Dventa::where('venta_id', $this->venta->id)->sum('total');
        $mc = Cuota::where('venta_id', $this->venta->id)->sum('monto');
        $this->mcuota = $mt - $mc;
    }

    public function gcredito()
    {
        $this->validate([
            'fvence' => 'required|date',
            'mcuota' => 'required|numeric|min:1',
        ], [
            'fvence.required' => 'Ingrese la fecha de vencimiento',
            'fvence.date' => 'Fecha de vencimiento no válida',
            'mcuota.required' => 'Ingrese el monto de la cuota',
            'mcuota.numeric' => 'El monto de la cuota debe ser un número',
            'mcuota.min' => 'El monto de la cuota debe ser mayor a 0',
        ]);

        $mt = Dventa::where('venta_id', $this->venta->id)->sum('total');
        $mc = Cuota::where('venta_id', $this->venta->id)->sum('monto');
        if (($mc + $this->mcuota) > $mt) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>El monto de la cuota es mayor al total de la venta']);
            return;
        }
        try {
            DB::beginTransaction();
            Cuota::create([
                'venta_id' => $this->venta->id,
                'monto' => $this->mcuota,
                'fvence' => $this->fvence,
                'created_by' => auth()->user()->id
            ]);
            if ($this->venta->fpago == null) {
                $this->venta->update([
                    'fpago' => 1,
                    'updated_by' => auth()->user()->id
                ]);
            }
            DB::commit();
            $this->dispatch('hmcre', ['t' => 'success', 'm' => '¡Hecho!<br>Cuota registrada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo registrar la cuota. ' . $e->getMessage()]);
        }
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
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo eliminar el pago. ' . $e->getMessage()]);
        }
    }

    public function emitir()
    {
        $this->mTitle = 'Emitir Comprobante';
        $this->mMethod = 'gemitir';
        $this->reset(['tcomprobante']);
        $this->dispatch('smemi');
    }

    public function gemitir()
    {
        $this->validate([
            'tcomprobante' => 'required|exists:tcomprobantes,id',
        ], [
            'tcomprobante.required' => 'Seleccione el tipo de comprobante',
            'tcomprobante.exists' => 'Tipo de comprobante no válido',
        ]);
        try {
            DB::beginTransaction();
            //obtenemos el tipo de comprobante
            $tcomprobante = Tcomprobante::find($this->tcomprobante);
            //obtenemos la serie del comprobante
            $serie = Serie::where('tcomprobante_id', $tcomprobante->id)
                ->where('sucursal_id', $this->sucursal->id)
                ->first();
            //obtenemos el correlativo que le tocaria al comprobante
            $correlativo = $serie->correlativo + 1;
            //actualizamos el correlativo de la serie
            $serie->update([
                'correlativo' => $correlativo
            ]);
            //actualizamos el comprobante de la venta
            $this->venta->update([
                'tcomprobante_id' => $this->tcomprobante,
                'serie' => $serie->serie,
                'correlativo' => $correlativo,
                'updated_by' => auth()->user()->id
            ]);

            DB::commit();
            //generar pdf
            $this->emitirpdf();
            //datos y evento para ver pdf
            $this->mTitle = 'Comprobante';
            $this->rComp = Storage::url('comprobantes/comprobante_' . $this->venta->id . '.pdf');
            $this->dispatch('vcomp');

            $this->dispatch('hmemi', ['t' => 'success', 'm' => '¡Hecho!<br>Comprobante emitido correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo emitir el comprobante. ' . $e->getMessage()]);
        }
    }

    public function emitirpdf()
    {
        $ancho = 226.77; // 80mm en puntos
        $alto_por_fila = 25; // Altura estimada por fila en puntos
        $numero_filas = $this->venta->dventas()->count();
        $alto = 180 + $alto_por_fila * $numero_filas;
        $pdf = Pdf::loadView('caja.comprobante', ['venta' => $this->venta])
            ->setPaper([0, 0, $ancho, $alto]);
        // Guardar el PDF en un archivo temporal
        $pdfPath = storage_path('app/public/comprobantes/comprobante_' . $this->venta->id . '.pdf');
        $pdf->save($pdfPath);
    }
}
