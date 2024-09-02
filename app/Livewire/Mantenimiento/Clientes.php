<?php

namespace App\Livewire\Mantenimiento;

use App\Models\Cliente;
use App\Models\Tdocumento;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Clientes extends Component
{
    use WithPagination;

    public $razon_social, $tdocumento, $ndocumento, $correo, $telefono, $direccion, $referencia, $ubigeo, $mMethod, $mTitle, $idm;
    public $tdocumentos, $vcliente;

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

    public function mount()
    {
        $this->tdocumentos = Tdocumento::where('estado', 1)->pluck('abreviatura', 'id');
    }

    #[Title(['Clientes', 'Mantenimiento'])]
    public function render()
    {
        $clientes = Cliente::where('razon_social', 'LIKE', "%" . $this->search . "%")
            ->orderBy('razon_social')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.clientes', compact('clientes'));
    }

    public function create()
    {
        $this->mMethod = 'store';
        $this->mTitle = 'Nuevo Cliente';
        $this->reset(['razon_social', 'ndocumento', 'correo', 'telefono', 'direccion', 'referencia', 'ubigeo']);
        $this->dispatch('sm');
    }

    public function store()
    {
        $this->validate([
            'razon_social' => 'required|unique:clientes,razon_social',
            'tdocumento' => 'required',
            'ndocumento' => 'required|unique:clientes,ndocumento',
            'correo' => 'nullable|email',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'ubigeo' => 'nullable|digits:6',
        ], [
            'razon_social.required' => 'Ingrese el nombre/razón social',
            'razon_social.unique' => 'El nombre/razón social ya existe',
            'tdocumento.required' => 'Elija el tipo de documento',
            'ndocumento.required' => 'Ingrese el número de documento',
            'ndocumento.unique' => 'El número de documento ya existe',
            'correo.email' => 'Ingrese un correo válido',
            'ubigeo.digits' => 'El ubigeo debe tener 6 dígitos',
        ]);

        Cliente::create([
            'razon_social' => mb_strtoupper($this->razon_social),
            'tdocumento_id' => $this->tdocumento,
            'ndocumento' => $this->ndocumento,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'referencia' => $this->referencia,
            'ubigeo' => $this->ubigeo,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Cliente registrado.']);
    }

    public function bDocumento()
    {
        $this->validate([
            'tdocumento' => 'required',
        ], [
            'tdocumento.required' => 'Elija el tipo de documento',
        ]);

        if ($this->tdocumento == 2) {
            $this->validate([
                'ndocumento' => 'required|numeric|digits:8|unique:clientes,ndocumento',
            ], [
                'ndocumento.required' => 'Ingrese el DNI',
                'ndocumento.numeric' => 'El DNI debe ser numérico',
                'ndocumento.digits' => 'El DNI debe tener 8 dígitos',
            ]);
            $data = json_decode(file_get_contents('https://dniruc.apisperu.com/api/v1/dni/' . $this->ndocumento . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlYXJnZXJhcmRAaG90bWFpbC5jb20ifQ.rtjR2w9OSrliEgIqzjmyzIomHLlhUrigJEmc0_nEYgw'));
            $this->resetValidation();
            $this->reset(['razon_social', 'direccion', 'ubigeo', 'correo', 'telefono', 'referencia']);
            if ($data->success) {
                $this->razon_social = $data->nombres . ' ' . $data->apellidoPaterno . ' ' . $data->apellidoMaterno;
            } else {
                $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>DNI no encontrado']);
            }
        } elseif ($this->tdocumento == 4) {
            $this->validate([
                'ndocumento' => 'required|numeric|digits:11|unique:clientes,ndocumento',
            ], [
                'ndocumento.required' => 'Ingrese el RUC',
                'ndocumento.numeric' => 'El RUC debe ser numérico',
                'ndocumento.digits' => 'El RUC debe tener 11 dígitos',
            ]);
            $data = json_decode(file_get_contents('https://dniruc.apisperu.com/api/v1/ruc/' . $this->ndocumento . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlYXJnZXJhcmRAaG90bWFpbC5jb20ifQ.rtjR2w9OSrliEgIqzjmyzIomHLlhUrigJEmc0_nEYgw'));

            $this->resetValidation();
            $this->reset(['razon_social', 'direccion', 'ubigeo', 'correo', 'telefono', 'referencia']);
            if (isset($data->success)) {
                $this->dispatch('re', ['t' => 'error', 'm' => '¡Error!<br>RUC no encontrado.']);
            } else {
                $this->razon_social = $data->razonSocial;
                $this->direccion = $data->direccion;
                $this->ubigeo = $data->ubigeo;
            }
        } else {
            $this->resetValidation();
            $this->reset(['razon_social', 'direccion', 'ubigeo', 'correo', 'telefono', 'referencia']);
            $this->dispatch('re', ['t' => 'info', 'm' => '¡Info!<br>Busqueda habilitada solo para DNI y RUC']);
            return;
        }
    }

    public function edit(Cliente $cliente)
    {
        $this->mMethod = 'update';
        $this->mTitle = 'Editar Cliente';
        $this->resetValidation();
        $this->idm = $cliente->id;
        $this->razon_social = $cliente->razon_social;
        $this->tdocumento = $cliente->tdocumento_id;
        $this->ndocumento = $cliente->ndocumento;
        $this->correo = $cliente->correo;
        $this->telefono = $cliente->telefono;
        $this->direccion = $cliente->direccion;
        $this->referencia = $cliente->referencia;
        $this->ubigeo = $cliente->ubigeo;
        $this->dispatch('sm');
    }

    public function update(){
        $this->validate([
            'razon_social' => 'required|unique:clientes,razon_social,'.$this->idm,
            'tdocumento' => 'required',
            'ndocumento' => 'required|unique:clientes,ndocumento,'.$this->idm,
            'correo' => 'nullable|email',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'ubigeo' => 'nullable|digits:6',
        ], [
            'razon_social.required' => 'Ingrese el nombre/razón social',
            'razon_social.unique' => 'El nombre/razón social ya existe',
            'tdocumento.required' => 'Elija el tipo de documento',
            'ndocumento.required' => 'Ingrese el número de documento',
            'ndocumento.unique' => 'El número de documento ya existe',
            'correo.email' => 'Ingrese un correo válido',
            'ubigeo.digits' => 'El ubigeo debe tener 6 dígitos',
        ]);

        Cliente::find($this->idm)->update([
            'razon_social' => mb_strtoupper($this->razon_social),
            'tdocumento_id' => $this->tdocumento,
            'ndocumento' => $this->ndocumento,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'referencia' => $this->referencia,
            'ubigeo' => $this->ubigeo,
            'updated_by' => auth()->user()->id,
        ]);
        $this->dispatch('hm', ['t' => 'success', 'm' => '¡Hecho!<br>Cliente actualizado.']);
    }

    public function status(Cliente $cliente)
    {
        $cliente->update([
            'estado' => $cliente->estado ? null : 1,
            'updated_by' => auth()->user()->id,
        ]);
        $this->dispatch('re', ['t' => 'success', 'm' => '¡Hecho!<br>Estado actualizado.']);
    }

    public function view(Cliente $cliente)
    {
        $this->mTitle = 'Ver Cliente';
        $this->vcliente = $cliente;
        $this->dispatch('smv');
    }
}
