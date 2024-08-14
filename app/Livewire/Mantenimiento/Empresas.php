<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Empresa;
use App\Models\Provincia;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class Empresas extends Component
{
    public $ruc, $razon_social, $nom_comercial, $dom_fiscal, $rep_legal, $distritoId, $provinciaId, $departamentoId, $usuario_sol, $clave_sol, $mMethod, $mTitle, $idm;

    public $dis, $distritos, $provincias, $departamentos;

    public function mount()
    {
        $this->departamentos = Departamento::all();
        $this->provincias = Provincia::where('departamento_id', Empresa::first()->distrito->provincia->departamento_id)->get();
        $this->distritos = Distrito::where('provincia_id', Empresa::first()->distrito->provincia_id)->get();
    }

    public function updatedDepartamentoId($value)
    {
        $this->provinciaId = null;
        $this->provincias = Provincia::where('departamento_id', $value)->get();
        $this->distritos=[];
    }

    public function updatedProvinciaId($value)
    {
        $this->distritos = Distrito::where('provincia_id', $value)->get();
    }

    #[Title(['Empresa', 'Mantenimiento'])]
    public function render()
    {
        $empresa=Empresa::first();
        return view('livewire.mantenimiento.empresas', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        $this->mTitle = 'EDITAR EMPRESA';
        $this->mMethod = 'update';
        $this->idm = $empresa->id;
        $this->ruc = $empresa->ruc;
        $this->razon_social = $empresa->razon_social;
        $this->nom_comercial = $empresa->nom_comercial;
        $this->dom_fiscal = $empresa->dom_fiscal;
        $this->rep_legal = $empresa->rep_legal;
        $this->distritoId = $empresa->distrito_id;
        $this->provinciaId = $empresa->distrito->provincia_id;
        $this->departamentoId = $empresa->distrito->provincia->departamento_id;

        $this->resetValidation();
        $this->dispatch('sm');
    }

    public function update()
    {
        $this->validate([
            'ruc' => 'required|digits:11|unique:empresas,ruc,'.$this->idm,
            'razon_social' => 'required',
            'nom_comercial' => 'required',
            'dom_fiscal' => 'required',
            'rep_legal' => 'nullable',
            'distritoId' => 'required',
            'provinciaId' => 'required',
            'departamentoId' => 'required',
        ], [
            'ruc.required' => 'El RUC es obligatorio',
            'ruc.digits' => 'El RUC debe tener 11 dígitos',
            'ruc.unique' => 'El RUC ya existe',
            'razon_social.required' => 'La razón social es obligatoria',
            'nom_comercial.required' => 'El nombre comercial es obligatorio',
            'dom_fiscal.required' => 'El domicilio fiscal es obligatorio',
            'distritoId.required' => 'El distrito es obligatorio',
            'provinciaId.required' => 'La provincia es obligatoria',
            'departamentoId.required' => 'El departamento es obligatorio',
        ]);

        $empresa = Empresa::find($this->idm);
        $empresa->ruc = $this->ruc;
        $empresa->razon_social = $this->razon_social;
        $empresa->nom_comercial = $this->nom_comercial;
        $empresa->dom_fiscal = $this->dom_fiscal;
        $empresa->rep_legal = $this->rep_legal;
        $empresa->distrito_id = $this->distritoId;
        $empresa->updated_by = auth()->id();
        $empresa->save();

        $this->dispatch('hm', ['t'=>'success', 'm'=>'¡Hecho!<br>Empresa actualizada']);

    }

    #[On('dispro')]
    public function dispro()
    {
        $this->provincias = Provincia::where('departamento_id', Empresa::first()->distrito->provincia->departamento_id)->get();
        $this->distritos = Distrito::where('provincia_id', Empresa::first()->distrito->provincia_id)->get();
    }

    public function editSunat(Empresa $empresa)
    {
        $this->mTitle = 'EDITAR DATOS SUNAT';
        $this->mMethod = 'updateSunat';
        $this->idm = $empresa->id;
        $this->usuario_sol = $empresa->usuario_sol;
        $this->clave_sol = $empresa->clave_sol;

        $this->resetValidation();
        $this->dispatch('sms');
    }

    public function updateSunat()
    {
        $this->validate([
            'usuario_sol' => 'required',
            'clave_sol' => 'required',
        ], [
            'usuario_sol.required' => 'El usuario SOL es obligatorio',
            'clave_sol.required' => 'La clave SOL es obligatoria',
        ]);

        $empresa = Empresa::find($this->idm);
        $empresa->usuario_sol = $this->usuario_sol;
        $empresa->clave_sol = $this->clave_sol;
        $empresa->updated_by = auth()->id();
        $empresa->save();

        $this->dispatch('hms', ['t'=>'success', 'm'=>'¡Hecho!<br>Datos SUNAT actualizados']);

    }
}
