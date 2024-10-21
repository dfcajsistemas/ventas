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
        $pagos = Pago::where('venta_id', $this->venta->id)->whereNull('estado')->get();
        //obtener pagos anulados
        $pagosAnulados = Pago::where('venta_id', $this->venta->id)->where('estado', 1)->get();
        //obtener los productos de la venta
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('dventas.id', 'productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.igv', 'dventas.total')
            ->where('dventas.venta_id', $this->venta->id)
            ->get();

        return view('livewire.caja.cobrar', compact('pagos', 'pagosAnulados', 'productos'));
    }

    //editar precio de un producto
    public function eprecio(Dventa $dventa)
    {
        $this->mTitle = 'Editar Precio';
        $this->mMethod = 'gprecio';
        $this->idm = $dventa->id;
        $this->precio = $dventa->precio;
        $this->dispatch('smp');
    }
    //guardar precio de un producto
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
        if ($dventa->producto->igvafectacion_id == 1) {
            $igv = $t * 0.18;
        } else {
            $igv = 0;
        }
        $dventa->update([
            'precio' => $this->precio,
            'total' => $t,
            'igv' => $igv,
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('hmp', ['t' => 'success', 'm' => '¡Hecho!<br>Precio cambiado correctamente']);
    }
    //agregar pago contado
    public function apagoContado()
    {
        $this->mTitle = 'Registrar Pago';
        $this->mMethod = 'gpagoContado';
        $this->reset(['mpago', 'mrecibido', 'observacion']);
        $this->monto = $this->mtotal - $this->mpagado;
        $this->dispatch('smc');
    }
    //guardar pago contado
    public function gpagoContado()
    {
        if (($this->mpagado + $this->monto) > $this->mtotal) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>El monto total a pagar es mayor al total de la venta']);
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

        try {
            DB::beginTransaction();
            Pago::create([
                'venta_id' => $this->venta->id,
                'mpago_id' => $this->mpago,
                'caja_id' => $this->caja->id,
                'monto' => $this->monto,
                'observacion' => $this->observacion,
                'created_by' => auth()->user()->id
            ]);
            if (($this->mpagado + $this->monto) == $this->mtotal) {
                $this->venta->update([
                    'est_pago' => null,
                    'updated_by' => auth()->user()->id
                ]);
            }
            if ($this->venta->pagos()->whereNull('estado')->count() == 1) {
                $afectaciones = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
                    ->join('igvafectacions', 'productos.igvafectacion_id', '=', 'igvafectacions.id')
                    ->join('igvporcientos', 'productos.igvporciento_id', '=', 'igvporcientos.id')
                    ->select('dventas.id', 'dventas.total', 'igvafectacions.codigo', 'igvporcientos.porcentaje')
                    ->where('dventas.venta_id', $this->venta->id)
                    ->get();
                $g = 0;
                $e = 0;
                $i = 0;
                $gigv = 0;
                foreach ($afectaciones as $afectacion) {
                    if ($afectacion->codigo == '10') {
                        $gigv += $afectacion->total;
                        $g += $afectacion->total / (1 + ($afectacion->porcentaje / 100));
                    } elseif ($afectacion->codigo == '20') {
                        $e += $afectacion->total;
                    } elseif ($afectacion->codigo == '30') {
                        $i += $afectacion->total;
                    }
                }
                $this->venta->update([
                    'op_grabada' => number_format($g, 6),
                    'op_exonerada' => $e,
                    'op_inafecta' => $i,
                    'igv' => number_format(($gigv - $g), 6),
                    'total' => $gigv + $e + $i,
                    'updated_by' => auth()->user()->id
                ]);
            }
            DB::commit();
            if ($this->mpago == 1) {
                $cambio = $this->mrecibido - $this->monto;
                $this->dispatch('vu', $cambio);
            }
            $this->dispatch('hmc', ['t' => 'success', 'm' => '¡Hecho!<br>Venta cobrada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo registrar el pago. ' . $e->getMessage()]);
        }
    }

    public function acredito()
    {
        $this->venta->update([
            'fpago' => $this->venta->fpago ? null : 1,
            'updated_by' => auth()->user()->id
        ]);
        $this->dispatch('hmc', ['t' => 'success', 'm' => '¡Hecho!<br>Se cambio la forma de pago.']);
    }

    public function acuota()
    {
        $this->mTitle = 'Cuotas';
        $this->mMethod = 'gcuota';
        $this->reset(['fvence', 'mcuota']);
        $this->dispatch('smcuo');
        $mt = Dventa::where('venta_id', $this->venta->id)->sum('total');
        $mc = Cuota::where('venta_id', $this->venta->id)->sum('monto');
        $this->mcuota = $mt - $mc;
    }
    public function gcuota()
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

        $cuota = Cuota::where('venta_id', $this->venta->id)->orderBy('id', 'desc')->first();
        if ($cuota) {
            if ($cuota->fvence > $this->fvence) {
                $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La fecha de vencimiento debe ser mayor a la última cuota']);
                return;
            }
        }
        try {
            DB::beginTransaction();
            Cuota::create([
                'numero' => (Cuota::where('venta_id', $this->venta->id)->max('numero') ?? 0) + 1,
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
            $this->dispatch('hmcuo', ['t' => 'success', 'm' => '¡Hecho!<br>Cuota registrada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('hmcuo', ['t' => 'error', 'm' => '¡Error!<br>No se pudo registrar la cuota. ' . $e->getMessage()]);
        }
    }

    #[On('delete')]
    public function destroyPago(Pago $pago)
    {
        DB::beginTransaction();
        try {
            $this->venta->update([
                'est_pago' => 1,
                'updated_by' => auth()->user()->id
            ]);

            if ($pago->cuota_id) {
                $cuota = Cuota::find($pago->cuota_id);
                $cuota->update([
                    'estado' => 1,
                    'updated_by' => auth()->user()->id
                ]);
            }

            $pago->update([
                'estado' => 1,
                'cuota_id' => null,
                'updated_by' => auth()->user()->id
            ]);
            DB::commit();
            $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Pago anulado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo anular el pago. ' . $e->getMessage()]);
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
            $this->vcomprobante();

            $this->dispatch('hmemi', ['t' => 'success', 'm' => '¡Hecho!<br>Comprobante emitido correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo emitir el comprobante. ' . $e->getMessage()]);
        }
    }

    public function vcomprobante()
    {
        $this->mTitle = 'Comprobante';
        $this->rComp = Storage::url('comprobantes/comprobante_' . $this->venta->id . '.pdf');
        $this->dispatch('vcomp');
    }

    public function emitirpdf()
    {
        $ancho = 226.77; // 80mm en puntos
        $alto_por_fila = 25; // Altura estimada por fila en puntos
        $numero_filas = $this->venta->dventas()->count();
        $alto = 220 + $alto_por_fila * $numero_filas;
        $pdf = Pdf::loadView('caja.comprobante', ['venta' => $this->venta])
            ->setPaper([0, 0, $ancho, $alto]);
        // Guardar el PDF en un archivo temporal
        $pdfPath = storage_path('app/public/comprobantes/comprobante_' . $this->venta->id . '.pdf');
        $pdf->save($pdfPath);
    }

    #[On('deletec')]
    public function destroyCuota(Cuota $cuota)
    {
        if ($cuota->pagos()->count() > 0) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La cuota tiene pagos registrados']);
            return;
        }
        $cuota->delete();
        $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Cuota eliminada correctamente']);
    }

    public function apagoCuota(Cuota $cuota)
    {
        $this->mTitle = 'Pago cuota';
        $this->mMethod = 'gpagoCuota';
        $this->monto = $cuota->monto - $cuota->pagos()->sum('monto');
        $this->idm = $cuota->id;
        $this->reset(['mpago', 'mrecibido', 'observacion']);
        $this->dispatch('smc');
    }

    public function gpagoCuota()
    {
        $cu = Cuota::where('estado', 1)->where('venta_id', $this->venta->id)->orderBy('id')->first();
        if ($this->idm != $cu->id) {
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>La cuota no es la próxima a pagar']);
            return;
        }
        $this->validate([
            'monto' => 'required|numeric|min:1',
            'mpago' => 'required',
            'mrecibido' => 'nullable|numeric|min:1|required_if:mpago,1',
        ], [
            'monto.required' => 'Ingrese el monto',
            'monto.numeric' => 'El monto debe ser un número',
            'monto.min' => 'El monto debe ser mayor a 0',
            'mpago.required' => 'Seleccione el medio de pago',
            'mrecibido.required_if' => 'Ingrese el monto recibido',
            'mrecibido.numeric' => 'El monto recibido debe ser mayor a 0',
            'mrecibido.min' => 'El monto recibido es inválido',
        ]);

        try {
            DB::beginTransaction();
            $pago = Pago::create([
                'cuota_id' => $this->idm,
                'mpago_id' => $this->mpago,
                'caja_id' => $this->caja->id,
                'venta_id' => $this->venta->id,
                'monto' => $this->monto,
                'observacion' => $this->observacion,
                'created_by' => auth()->user()->id
            ]);
            if ($cu->pagos()->sum('monto') == $cu->monto) {
                $cu->update([
                    'estado' => null,
                    'updated_by' => auth()->user()->id
                ]);
            }
            if ($this->venta->pagos()->whereNull('estado')->sum('monto') == $this->mtotal) {
                $this->venta->update([
                    'est_pago' => null,
                    'updated_by' => auth()->user()->id
                ]);
            }
            if ($this->venta->pagos()->whereNull('estado')->count() == 1) {
                $afectaciones = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
                    ->join('igvafectacions', 'productos.igvafectacion_id', '=', 'igvafectacions.id')
                    ->join('igvporcientos', 'productos.igvporciento_id', '=', 'igvporcientos.id')
                    ->select('dventas.id', 'dventas.total', 'igvafectacions.codigo', 'igvporcientos.porcentaje')
                    ->where('dventas.venta_id', $this->venta->id)
                    ->get();
                $g = 0;
                $e = 0;
                $i = 0;
                $gigv = 0;
                foreach ($afectaciones as $afectacion) {
                    if ($afectacion->codigo == '10') {
                        $gigv += $afectacion->total;
                        $g += $afectacion->total / (1 + ($afectacion->porcentaje / 100));
                    } elseif ($afectacion->codigo == '20') {
                        $e += $afectacion->total;
                    } elseif ($afectacion->codigo == '30') {
                        $i += $afectacion->total;
                    }
                }
                $this->venta->update([
                    'op_grabada' => number_format($g, 6),
                    'op_exonerada' => $e,
                    'op_inafecta' => $i,
                    'igv' => number_format(($gigv - $g), 6),
                    'total' => $gigv + $e + $i,
                    'updated_by' => auth()->user()->id
                ]);
            }
            DB::commit();
            if ($this->mpago == 1) {
                $cambio = $this->mrecibido - $this->monto;
                $this->dispatch('vu', $cambio);
            }
            $this->dispatch('hmc', ['t' => 'success', 'm' => '¡Hecho!<br>Pago de cuota realizado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>No se pudo registrar el pago. ' . $e->getMessage()]);
        }
    }
}
