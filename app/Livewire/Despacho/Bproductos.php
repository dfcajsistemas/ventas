<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Bproductos extends Component
{
    use WithPagination;

    public $sucursal, $venta;
    #[Url(except: '')]
    public $search = '';
    #[Url(except: '10')]
    public $perPage = '10';

    public function mount(Venta $venta)
    {
        $this->venta = $venta;
        $this->sucursal = auth()->user()->sucursal;
    }

    #[On('abp')]
    public function render()
    {
        $productos = Producto::join('stocks', 'productos.id', '=', 'stocks.producto_id')
            ->select('productos.id', 'productos.nombre', 'productos.p_venta' . $this->sucursal->p_venta . ' as p_venta', 'stocks.stock')
            ->where('stocks.sucursal_id', $this->sucursal->id)
            ->where('stocks.stock', '>', 0)
            ->where('productos.nombre', 'LIKE', "%" . $this->search . "%")
            ->orderBy('productos.nombre')
            ->paginate($this->perPage);
        return view('livewire.despacho.bproductos', compact('productos'));
    }

    public function add(Producto $producto)
    {
        $dventa = Dventa::where('venta_id', $this->venta->id)
            ->where('producto_id', $producto->id)
            ->first();
        //obtenemos el stock del producto en la sucursal del usuario
        $stock = $producto->stocks->where('sucursal_id', $this->sucursal->id)->first();
        //obtenemos el % de igv para el producto
        $pigv = $producto->igvporciento->porcentaje;

        $a = 0;
        if ($stock->stock <= 0) {
            $this->dispatch('rep', ['t' => 'error', 'm' => '¡Error!<br>Stock insuficiente']);
            return;
        } elseif ($stock->stock > 0 && $stock->stock < 1) {
            $a = $stock->stock;
        } elseif ($stock->stock >= 1) {
            $a = 1;
        }

        if ($dventa) {

            $c = $dventa->cantidad + $a;
            $p = $dventa->precio;
            $t = round($p * $c, 6);
            if ($producto->igvafectacion_id == 1) {
                $igv = round((($t * $pigv) / (100 + $pigv)), 6);
            } else {
                $igv = 0;
            }

            try {
                DB::beginTransaction();
                $stock->update([
                    'stock' => $stock->stock - $a,
                    'updated_by' => auth()->user()->id
                ]);

                $dventa->update([
                    'cantidad' => $c,
                    'precio' => $p,
                    'igv' => $igv,
                    'total' => $t,
                    'updated_by' => auth()->user()->id
                ]);
                DB::commit();
                $this->dispatch('rep', ['t' => 'success', 'm' => '¡Hecho!<br>Se agregó una unidad más del producto']);
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('rep', ['t' => 'error', 'm' => '¡Error!<br>Hubo un problema al agregar el producto']);
            }
        } else {
            $p = $producto->{'p_venta' . $this->sucursal->p_venta};

            try {
                DB::beginTransaction();
                $stock->update([
                    'stock' => $stock->stock - $a,
                    'updated_by' => auth()->user()->id
                ]);

                Dventa::create([
                    'venta_id' => $this->venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $a,
                    'precio' => $p,
                    'igv' => (($producto->igvafectacion_id == 1) ? round(((round($p * $a, 6) * $pigv) / (100 + $pigv)), 6) : 0),
                    'total' => round($a * $p, 6),
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                $this->dispatch('rep', ['t' => 'success', 'm' => '¡Hecho!<br>Producto agregado']);
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('rep', ['t' => 'error', 'm' => '¡Error!<br>Hubo un problema al agregar el producto']);
            }
        }
    }
}
