<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
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

        $stock = $producto->stocks->where('sucursal_id', $this->sucursal->id)->first();

        if ($stock->stock < 1) {
            $this->dispatch('rep', ['t' => 'error', 'm' => '¡Error!<br>Stock insuficiente']);
            return;
        }

        if ($dventa) {

            $c = $dventa->cantidad + 1;
            $p = $producto->{'p_venta' . $this->sucursal->p_venta};
            $t = $p * $c;
            if ($producto->igvafectacion_id == 1) {
                $igv = $t * 0.18;
            } else {
                $igv = 0;
            }

            try {
                DB::beginTransaction();
                $stock->update([
                    'stock' => $stock->stock - 1,
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
                $this->dispatch('rep', ['t' => 'success', 'm' => '¡Hecho!<br>Se agregó una unidad más a la canasta']);
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('rep', ['t' => 'error', 'm' => '¡Error!<br>Hubo un problema al agregar el producto a la canasta']);
            }
        } else {
            $p = $producto->{'p_venta' . $this->sucursal->p_venta};

            try {
                DB::beginTransaction();
                $stock->update([
                    'stock' => $stock->stock - 1,
                    'updated_by' => auth()->user()->id
                ]);

                Dventa::create([
                    'venta_id' => $this->venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => 1,
                    'precio' => $p,
                    'igv' => (($producto->igvafectacion_id == 1) ? ($p * 0.18) : 0),
                    'total' => $p,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                $this->dispatch('rep', ['t' => 'success', 'm' => '¡Hecho!<br>Producto agregado a la canasta']);
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('rep', ['t' => 'error', 'm' => '¡Error!<br>Hubo un problema al agregar el producto a la canasta']);
            }
        }
    }
}
