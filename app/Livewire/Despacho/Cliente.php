<?php

namespace App\Livewire\Despacho;

use App\Models\Cliente as ModelsCliente;
use App\Models\Tdocumento;
use Livewire\Component;

class Cliente extends Component
{
    public $razon_social, $ndocumento, $correo, $telefono, $direccion,  $referencia, $ubigeo, $tdocumento, $fnacimiento, $mMethod, $mTitle;
    public $tdocumentos;

    public function mount()
    {
        $this->tdocumentos = Tdocumento::where('estado', 1)->pluck('abreviatura', 'id');
    }

    public function render()
    {
        return view('livewire.despacho.cliente');
    }

    public function create()
    {
        $this->mMethod = 'store';
        $this->mTitle = 'Nuevo Cliente';
        $this->reset(['razon_social', 'tdocumento', 'ndocumento', 'correo', 'telefono', 'direccion', 'referencia', 'ubigeo', 'fnacimiento']);
        $this->dispatch('smc');
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
            'fnacimiento' => 'nullable|date',
        ], [
            'razon_social.required' => 'Ingrese el nombre/razón social',
            'razon_social.unique' => 'El nombre/razón social ya existe',
            'tdocumento.required' => 'Elija el tipo de documento',
            'ndocumento.required' => 'Ingrese el número de documento',
            'ndocumento.unique' => 'El número de documento ya existe',
            'correo.email' => 'Ingrese un correo válido',
            'ubigeo.digits' => 'El ubigeo debe tener 6 dígitos',
            'fnacimiento.date' => 'Ingrese una fecha válida',
        ]);

        ModelsCliente::create([
            'razon_social' => mb_strtoupper($this->razon_social),
            'tdocumento_id' => $this->tdocumento,
            'ndocumento' => $this->ndocumento,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'referencia' => $this->referencia,
            'ubigeo' => $this->ubigeo,
            'fnacimiento' => $this->fnacimiento,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        $this->dispatch('hmc', ['t' => 'success', 'm' => '¡Hecho!<br>Cliente registrado.']);
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
                'ndocumento.unique' => 'El DNI ya existe',
            ]);
            $data = json_decode(file_get_contents('https://dniruc.apisperu.com/api/v1/dni/' . $this->ndocumento . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlYXJnZXJhcmRAaG90bWFpbC5jb20ifQ.rtjR2w9OSrliEgIqzjmyzIomHLlhUrigJEmc0_nEYgw'));
            $this->resetValidation();
            $this->reset(['razon_social', 'direccion', 'ubigeo', 'correo', 'telefono', 'referencia']);
            if ($data->success) {
                $this->razon_social = $data->nombres . ' ' . $data->apellidoPaterno . ' ' . $data->apellidoMaterno;
            } else {
                $this->dispatch('rec', ['t' => 'error', 'm' => '¡Error!<br>DNI no encontrado']);
            }
        } elseif ($this->tdocumento == 4) {
            $this->validate([
                'ndocumento' => 'required|numeric|digits:11|unique:clientes,ndocumento',
            ], [
                'ndocumento.required' => 'Ingrese el RUC',
                'ndocumento.numeric' => 'El RUC debe ser numérico',
                'ndocumento.digits' => 'El RUC debe tener 11 dígitos',
                'ndocumento.unique' => 'El RUC ya existe',
            ]);
            $data = json_decode(file_get_contents('https://dniruc.apisperu.com/api/v1/ruc/' . $this->ndocumento . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlYXJnZXJhcmRAaG90bWFpbC5jb20ifQ.rtjR2w9OSrliEgIqzjmyzIomHLlhUrigJEmc0_nEYgw'));

            $this->resetValidation();
            $this->reset(['razon_social', 'direccion', 'ubigeo', 'correo', 'telefono', 'referencia']);
            if (isset($data->success)) {
                $this->dispatch('rec', ['t' => 'error', 'm' => '¡Error!<br>RUC no encontrado.']);
            } else {
                $this->razon_social = $data->razonSocial;
                $this->direccion = $data->direccion;
                $this->ubigeo = $data->ubigeo;
            }
        } else {
            $this->resetValidation();
            $this->reset(['razon_social', 'direccion', 'ubigeo', 'correo', 'telefono', 'referencia']);
            $this->dispatch('rec', ['t' => 'info', 'm' => '¡Info!<br>Busqueda habilitada solo para DNI y RUC']);
            return;
        }
    }
}
