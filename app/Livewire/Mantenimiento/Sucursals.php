<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Empresa;
use App\Models\Provincia;
use App\Models\Serie;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Sucursals extends Component
{
    use WithPagination;

    public $nombre, $direccion, $telefono, $cod_sunat, $p_venta, $distrito_id, $provincia_id, $departamento_id, $empresa_id, $mMethod, $mTitle, $idm;
    public $departamentos, $provincias, $distritos, $empresa;
    #[Url(except: '10')]
    public $perPage = '10';
    #[Url(except: '')]
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedDepartamentoId($value)
    {
        $this->provincia_id = null;
        $this->provincias = Provincia::where('departamento_id', $value)->get();
        $this->distritos=[];
    }

    public function updatedProvinciaId($value)
    {
        $this->distritos = Distrito::where('provincia_id', $value)->get();
    }

    public function mount()
    {
        $this->empresa = Empresa::first();
        $this->departamentos = Departamento::all();
    }

    #[Title(['Sucursales', 'Mantenimiento'])]
    public function render()
    {
        $sucursals=Sucursal::where('nombre', 'LIKE', "%".$this->search."%")
                    ->orderBy('nombre')
                    ->paginate($this->perPage);
        return view('livewire.mantenimiento.sucursals', compact('sucursals'));
    }

    public function create()
    {
        $this->mTitle = 'NUEVA SUCURSAL';
        $this->mMethod = 'store';
        $this->reset(['nombre', 'direccion', 'telefono', 'cod_sunat', 'p_venta', 'distrito_id', 'provincia_id', 'departamento_id']);
        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|unique:sucursals,nombre',
            'direccion' => 'required',
            'telefono' => 'nullable',
            'cod_sunat' => 'required|unique:sucursals,cod_sunat',
            'p_venta' => 'required|in:1,2,3',
            'distrito_id' => 'required',
            'provincia_id' => 'required',
            'departamento_id' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'La sucursal ya existe',
            'direccion.required' => 'La dirección es obligatoria',
            'cod_sunat.required' => 'El código sunat es obligatorio',
            'cod_sunat.unique' => 'El código sunat ya existe',
            'p_venta.required' => 'Elija el precio de venta a usar',
            'p_venta.in' => 'El precio de venta elegido no es válido',
            'distrito_id.required' => 'El distrito es obligatorio',
            'provincia_id.required' => 'La provincia es obligatoria',
            'departamento_id.required' => 'El departamento es obligatorio',
        ]);

        DB::beginTransaction();
        try {
            $sucursal=Sucursal::create([
                'nombre' => $this->nombre,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'cod_sunat' => $this->cod_sunat,
                'p_venta' => $this->p_venta,
                'distrito_id' => $this->distrito_id,
                'empresa_id' => $this->empresa->id,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);

            DB::commit();
            $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Haz registrado la sucursal.']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('hm', ['t'=>'error', 'm'=>$e->getMessage()]);
        }

    }

    public function edit(Sucursal $sucursal)
    {
        $this->dispro($sucursal);
        $this->mTitle = 'EDITAR SUCURSAL';
        $this->mMethod = 'update';
        $this->resetValidation();

        $this->idm = $sucursal->id;
        $this->nombre = $sucursal->nombre;
        $this->direccion = $sucursal->direccion;
        $this->telefono = $sucursal->telefono;
        $this->cod_sunat = $sucursal->cod_sunat;
        $this->p_venta = $sucursal->p_venta;
        $this->distrito_id = $sucursal->distrito_id;
        $this->provincia_id = $sucursal->distrito->provincia_id;
        $this->departamento_id = $sucursal->distrito->provincia->departamento_id;


        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|unique:sucursals,nombre,'.$this->idm,
            'direccion' => 'required',
            'telefono' => 'nullable',
            'cod_sunat' => 'required|unique:sucursals,cod_sunat,'.$this->idm,
            'p_venta' => 'required|in:1,2,3',
            'distrito_id' => 'required',
            'provincia_id' => 'required',
            'departamento_id' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'La sucursal ya existe',
            'direccion.required' => 'La dirección es obligatoria',
            'cod_sunat.required' => 'El código SUNAT es obligatorio',
            'cod_sunat.unique' => 'El código SUNAT ya existe',
            'p_venta.required' => 'Elija el precio de venta a usar',
            'p_venta.in' => 'El precio de venta elegido no es válido',
            'distrito_id.required' => 'El distrito es obligatorio',
            'provincia_id.required' => 'La provincia es obligatoria',
            'departamento_id.required' => 'El departamento es obligatorio',
        ]);

        $sucursal = Sucursal::find($this->idm);
        $sucursal->nombre = $this->nombre;
        $sucursal->direccion = $this->direccion;
        $sucursal->telefono = $this->telefono;
        $sucursal->cod_sunat = $this->cod_sunat;
        $sucursal->p_venta = $this->p_venta;
        $sucursal->distrito_id = $this->distrito_id;
        $sucursal->updated_by = auth()->id();
        $sucursal->save();

        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Haz editado la sucursal.']);
    }

    public function dispro(Sucursal $sucursal)
    {
        $this->provincias = Provincia::where('departamento_id', $sucursal->distrito->provincia->departamento_id)->get();
        $this->distritos = Distrito::where('provincia_id', $sucursal->distrito->provincia_id)->get();
    }

    public function estado(Sucursal $sucursal)
    {
        $sucursal->estado = $sucursal->estado ? null : 1;
        $sucursal->updated_by = auth()->id();
        $sucursal->save();

        $this->dispatch('re', ['t'=>'success', 'm'=>'¡Hecho!<br>Se cambio el estado de la sucursal']);
    }

}
