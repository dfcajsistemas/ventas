<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Categoria;
use App\Models\Igvafectacion;
use App\Models\Igvporciento;
use App\Models\Producto;
use App\Models\Umedida;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

#[Lazy()]
class Productos extends Component
{
    use WithPagination;

    public $nombre, $codigo, $descripcion, $icbper, $p_costo, $p_venta1, $p_venta2, $p_venta3, $umedida_id, $categoria_id, $igvafectacion_id, $igvporciento_id, $mMethod, $mTitle, $idm;
    public $umedidas, $igvafectacions, $categorias, $igvporcientos;

    public $prod = [];

    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    public function mount()
    {
        $this->umedidas = Umedida::where('estado', 1)->pluck('descripcion', 'id');
        $this->igvafectacions = Igvafectacion::where('estado', 1)->pluck('descripcion', 'id');
        $this->categorias = Categoria::where('estado', 1)->pluck('nombre', 'id');
        $this->igvporcientos = Igvporciento::where('estado', 1)->pluck('porcentaje', 'id');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[Title(['Productos', 'Mantenimiento'])]
    public function render()
    {
        $productos = Producto::select('id', 'nombre', 'codigo', 'estado', 'categoria_id')
            ->where('nombre', 'LIKE', "%" . $this->search . "%")
            ->orWhere('codigo', 'LIKE', "%" . $this->search . "%")
            ->orderBy('nombre')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.productos', compact('productos'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVO PRODUCTO';
        $this->mMethod = 'store';
        $this->reset(['nombre', 'codigo', 'descripcion', 'icbper', 'p_costo', 'p_venta1', 'p_venta2', 'p_venta3', 'umedida_id', 'categoria_id', 'igvafectacion_id', 'igvporciento_id']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        //dd($this->p_venta1);
        $this->validate([
            'nombre' => 'required|unique:productos,nombre',
            'codigo' => 'required|unique:productos,codigo',
            'descripcion' => 'nullable',
            'icbper' => 'nullable',
            'p_costo' => 'nullable|numeric',
            'p_venta1' => 'required|numeric',
            'p_venta2' => 'nullable|numeric',
            'p_venta3' => 'nullable|numeric',
            'umedida_id' => 'required',
            'categoria_id' => 'required',
            'igvafectacion_id' => 'required',
            'igvporciento_id' => 'required',
        ], [
            'nombre.required' => 'Ingrese el nombre',
            'nombre.unique' => 'El nombre ya existe',
            'codigo.required' => 'Ingrese el código',
            'codigo.unique' => 'El código ya existe',
            'p_costo.numeric' => 'Ingrese un valor numérico',
            'p_venta1.required' => 'Ingrese el precio de venta',
            'p_venta1.numeric' => 'Ingrese un valor numérico',
            'p_venta2.numeric' => 'Ingrese un valor numérico',
            'p_venta3.numeric' => 'Ingrese un valor numérico',
            'umedida_id.required' => 'Elija la unidad de medida',
            'categoria_id.required' => 'Elija la categoría',
            'igvafectacion_id.required' => 'Elija afectación de IGV',
            'igvporciento_id.required' => 'Elija porcentaje de IGV',
        ]);

        Producto::create([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre),
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'icbper' => $this->icbper,
            'p_costo' => $this->p_costo,
            'p_venta1' => $this->p_venta1,
            'p_venta2' => $this->p_venta2,
            'p_venta3' => $this->p_venta3,
            'umedida_id' => $this->umedida_id,
            'categoria_id' => $this->categoria_id,
            'igvafectacion_id' => $this->igvafectacion_id,
            'igvporciento_id' => $this->igvporciento_id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);

        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Producto registrado']);
    }

    public function edit(Producto $producto)
    {
        $this->mTitle = 'EDITAR PRODUCTO';
        $this->mMethod = 'update';
        $this->nombre = $producto->nombre;
        $this->codigo = $producto->codigo;
        $this->descripcion = $producto->descripcion;
        $this->icbper = $producto->icbper;
        $this->p_costo = $producto->p_costo;
        $this->p_venta1 = $producto->p_venta1;
        $this->p_venta2 = $producto->p_venta2;
        $this->p_venta3 = $producto->p_venta3;
        $this->umedida_id = $producto->umedida_id;
        $this->categoria_id = $producto->categoria_id;
        $this->igvafectacion_id = $producto->igvafectacion_id;
        $this->igvporciento_id = $producto->igvporciento_id;
        $this->idm = $producto->id;

        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|unique:productos,nombre,' . $this->idm,
            'codigo' => 'required|unique:productos,codigo,' . $this->idm,
            'descripcion' => 'nullable',
            'icbper' => 'nullable',
            'p_costo' => 'nullable|numeric',
            'p_venta1' => 'required|numeric',
            'p_venta2' => 'nullable|numeric',
            'p_venta3' => 'nullable|numeric',
            'umedida_id' => 'required',
            'categoria_id' => 'required',
            'igvafectacion_id' => 'required',
            'igvporciento_id' => 'required',
        ], [
            'nombre.required' => 'Ingrese el nombre',
            'nombre.unique' => 'El nombre ya existe',
            'codigo.required' => 'Ingrese el código',
            'codigo.unique' => 'El código ya existe',
            'p_costo.numeric' => 'Ingrese un valor numérico',
            'p_venta1.required' => 'Ingrese el precio de venta',
            'p_venta1.numeric' => 'Ingrese un valor numérico',
            'p_venta2.numeric' => 'Ingrese un valor numérico',
            'p_venta3.numeric' => 'Ingrese un valor numérico',
            'umedida_id.required' => 'Elija la unidad de medida',
            'categoria_id.required' => 'Elija la categoría',
            'igvafectacion_id.required' => 'Elija afectación de IGV',
            'igvporciento_id.required' => 'Elija porcentaje de IGV',
        ]);

        Producto::where('id', $this->idm)->update([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre),
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'icbper' => $this->icbper,
            'p_costo' => $this->p_costo,
            'p_venta1' => $this->p_venta1,
            'p_venta2' => $this->p_venta2,
            'p_venta3' => $this->p_venta3,
            'umedida_id' => $this->umedida_id,
            'categoria_id' => $this->categoria_id,
            'igvafectacion_id' => $this->igvafectacion_id,
            'igvporciento_id' => $this->igvporciento_id,
            'updated_by' => auth()->id()
        ]);

        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Editaste el producto']);
    }

    public function status(Producto $producto)
    {
        $producto->estado = $producto->estado ? null : 1;
        $producto->save();
        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Cambiaste el estado del producto']);
    }

    public function details(Producto $producto)
    {
        $this->prod = $producto;
        //dd($this->producto);
        $this->dispatch('smd');
    }

    #[On('delete')]
    public function destroy(Producto $producto)
    {
        if ($producto->stocks->count() > 0) {
            $this->dispatch('rd', ['t' => 'error', 'm' => '¡Error!<br>El producto tiene movimientos de stock']);
            return;
        }
        if ($producto->reposicions->count() > 0) {
            $this->dispatch('rd', ['t' => 'error', 'm' => '¡Error!<br>El producto tiene reposiciones registradas']);
            return;
        }
        if ($producto->dventas->count() > 0) {
            $this->dispatch('rd', ['t' => 'error', 'm' => '¡Error!<br>El producto esta incluido en alguna venta']);
            return;
        }

        $producto->delete();
        $this->dispatch('rd', ['t' => 'success', 'm' => '¡Hecho!<br>Producto eliminado']);
    }
}
