<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Eventa;
use App\Models\Serie;
use App\Models\Sucursal;
use App\Models\Tcomprobante;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Cproductos extends Component
{
    public $cantidad, $precio, $mTitle, $mMethod, $idm;
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
            'cantidad' => 'required|numeric|min:0.01',
        ], [
            'cantidad.required' => 'Ingrese la cantidad',
            'cantidad.numeric' => 'La cantidad debe ser un número',
            'cantidad.min' => 'La cantidad debe ser mayor a 0',
        ]);
        $dventa = Dventa::find($this->idm);

        $stock = $dventa->producto->stocks->where('sucursal_id', auth()->user()->sucursal->id)->first();
        $nc = round($this->cantidad, 2) - $dventa->cantidad;
        if ($stock->stock < $nc) {
            $this->dispatch('hmca', ['t' => 'error', 'm' => '¡Error!<br>Stock insuficiente']);
            return;
        }

        //obtenemos el porcentaje del igv
        $pigv = $dventa->producto->igvporciento->porcentaje;

        $p = $dventa->precio;
        $t = round($p * round($this->cantidad, 2), 6);
        if ($dventa->producto->igvafectacion_id == 1) {
            $igv = round((($t * $pigv) / (100 + $pigv)), 6);
        } else {
            $igv = 0;
        }

        try {
            DB::beginTransaction();
            $stock->update([
                'stock' => round(($stock->stock - $nc), 2),
                'updated_by' => auth()->user()->id
            ]);

            $dventa->update([
                'cantidad' => round($this->cantidad, 2),
                'total' => $t,
                'igv' => $igv
            ]);
            DB::commit();
            $this->dispatch('hmca', ['t' => 'success', 'm' => '¡Hecho!<br>Cantidad actualizada correctamente']);
            $this->dispatch('abp');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('hmca', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
        }
    }

    public function eprecio($id)
    {
        $this->mTitle = 'Editar Precio';
        $this->mMethod = 'gprecio';
        $this->idm = $id;
        $this->precio = Dventa::find($id)->precio;
        $this->resetValidation();
        $this->dispatch('smpr');
    }

    public function gprecio()
    {
        $this->validate([
            'precio' => 'required|numeric|min:0.00',
        ], [
            'precio.required' => 'Ingrese el precio',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio debe ser mayor o igual a 0',
        ]);
        $dventa = Dventa::find($this->idm);

        //obtenemos el porcentaje del igv
        $pigv = $dventa->producto->igvporciento->porcentaje;

        $t = round(round($this->precio, 2) * $dventa->cantidad, 6);
        if ($dventa->producto->igvafectacion_id == 1) {
            $igv = round((($t * $pigv) / (100 + $pigv)), 6);
        } else {
            $igv = 0;
        }

        try {
            DB::beginTransaction();
            $dventa->update([
                'precio' => round($this->precio, 2),
                'total' => $t,
                'igv' => $igv,
                'updated_by' => auth()->user()->id
            ]);
            DB::commit();
            $this->dispatch('hmpr', ['t' => 'success', 'm' => '¡Hecho!<br>Precio actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('hmpr', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
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
            $this->dispatch('abp');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('reca', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
        }
    }

    #[On('addPedido')]
    public function genPedido()
    {
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
                $g += round($afectacion->total / (1 + ($afectacion->porcentaje / 100)), 6);
            } elseif ($afectacion->codigo == '20') {
                $e += $afectacion->total;
            } elseif ($afectacion->codigo == '30') {
                $i += $afectacion->total;
            }
        }

        try {
            DB::beginTransaction();
            //obtenemos la sucursal de la venta
            $sucursal = Sucursal::find($this->cventa->sucursal_id);
            //actualizamos el correlativo en la sucursal
            if ($sucursal->ano_ticket == date('Y')) {
                $correlativo = $sucursal->cor_ticket + 1;
                $sucursal->update([
                    'cor_ticket' => $correlativo,
                ]);
            } else {
                $correlativo = 1;
                $sucursal->update([
                    'cor_ticket' => $correlativo,
                    'ano_ticket' => date('Y')
                ]);
            }
            //actualizamos la venta y la serie del ticket
            $this->cventa->update([
                'cor_ticket' => $correlativo,
                'op_grabada' => number_format($g, 6, '.', ''),
                'op_exonerada' => number_format($e, 6, '.', ''),
                'op_inafecta' => number_format($i, 6, '.', ''),
                'igv' => number_format(($gigv - $g), 6, '.', ''),
                'total' => number_format($gigv + $e + $i, 6, '.', ''),
                'est_venta' => 1,
                'updated_by' => auth()->user()->id
            ]);
            //creamos el estado de venta
            Eventa::create([
                'venta_id' => $this->cventa->id,
                'est_venta' => 1,
                'user_id' => auth()->user()->id
            ]);
            DB::commit();
            // $this->dispatch('reca', ['t' => 'success', 'm' => '¡Hecho!<br>Pedido generado correctamente, ya no se podrá agregar más productos']);
            // $this->dispatch('abp');
            return redirect()->route('despacho.dpedidos.distribuir', $this->cventa->id)->with('success', '¡Hecho!Pedido generado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('reca', ['t' => 'error', 'm' => '¡Error!<br>' . $e->getMessage()]);
            return;
        }
    }
}
