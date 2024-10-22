<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Eventa;
use App\Models\Serie;
use App\Models\Tcomprobante;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Cproductos extends Component
{
    public $cantidad, $mTitle, $mMethod, $idm;
    public $cventa;
    public function mount(Venta $venta)
    {
        $this->cventa = $venta;
    }
    #[On('rep')]
    public function render()
    {
        $productos = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->select('dventas.id', 'productos.nombre', 'dventas.cantidad', 'dventas.precio', 'dventas.igv', 'dventas.total')
            ->where('dventas.venta_id', $this->cventa->id)
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

    public function genPedido()
    {
        $tcomprobante_id = Tcomprobante::where('codigo', 'TK')->first()->id;
        $serie = Serie::where('sucursal_id', auth()->user()->sucursal->id)->where('tcomprobante_id', $tcomprobante_id)->first();

        try {
            DB::beginTransaction();
            //obtenemos el correlativo
            $correlativo = $serie->correlativo + 1;
            //calculamos los montos de operaciones grabadas, exoneradas e inafectas
            $afectaciones = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
                ->join('igvafectacions', 'productos.igvafectacion_id', '=', 'igvafectacions.id')
                ->join('igvporcientos', 'productos.igvporciento_id', '=', 'igvporcientos.id')
                ->select('dventas.id', 'dventas.total', 'igvafectacions.codigo', 'igvporcientos.porcentaje')
                ->where('dventas.venta_id', $this->cventa->id)
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
            //actualizamos la venta y la serie del ticket
            $this->cventa->update([
                'ser_ticket' => $serie->serie,
                'cor_ticket' => $correlativo,
                'op_grabada' => number_format($g, 6),
                'op_exonerada' => $e,
                'op_inafecta' => $i,
                'igv' => number_format(($gigv - $g), 6),
                'total' => $gigv + $e + $i,
                'est_venta' => 1,
                'updated_by' => auth()->user()->id
            ]);
            //actualizamos el correlativo de la serie
            $serie->update([
                'correlativo' => $correlativo,
                'updated_by' => auth()->user()->id
            ]);
            //creamos el estado de venta
            Eventa::created([
                'venta_id' => $this->cventa->id,
                'est_venta' => 1,
                'user_id' => auth()->user()->id
            ]);
            DB::commit();
            $this->dispatch('reca', ['t' => 'success', 'm' => '¡Hecho!<br>Pedido generado correctamente, ya no se podrá agregar más productos']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('reca', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
            return;
        }
    }
}
