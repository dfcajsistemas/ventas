<?php

namespace App\Livewire\Despacho;

use App\Models\Dventa;
use App\Models\Producto;
use App\Models\Venta;
use Livewire\Attributes\Url;
use Livewire\Component;

class Bproductos extends Component
{
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
        if ($dventa) {
            $c= $dventa->cantidad + 1;
            $p= $producto->{'p_venta'.$this->sucursal->p_venta};
            $t= $p * $c;
            $igv= $t * 0.18;
            $dventa->update([
                'cantidad' => $c,
                'precio' => $p,
                'igv' => $igv,
                'total' => $t,
                'updated_by' => auth()->user()->id
            ]);
            $this->dispatch('rep', ['t' => 'success', 'm' => '¡Hecho!<br>Se agregó una unidad más a la canasta']);
        }else{
            $p= $producto->{'p_venta'.$this->sucursal->p_venta};
            Dventa::create([
                'venta_id' => $this->venta->id,
                'producto_id' => $producto->id,
                'cantidad' => 1,
                'precio' => $p,
                'igv' => $p * 0.18,
                'total' => $p,
                'created_by' => auth()->user()->id,
            ]);
            $this->dispatch('rep', ['t' => 'success', 'm' => '¡Hecho!<br>Producto agregado a la canasta']);
        }
    }
}
