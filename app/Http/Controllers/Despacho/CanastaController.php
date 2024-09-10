<?php

namespace App\Http\Controllers\Despacho;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class CanastaController extends Controller
{


    public function canasta(Venta $venta)
    {
        $sucursal = auth()->user()->sucursal;
        $venta->load('productos');
        return view('despacho.canasta', compact('venta', 'sucursal'));
    }

    public function updateCliente(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'venta_id' => 'required|exists:ventas,id',
        ]);

        $venta = Venta::find($request->input('venta_id'));
        $venta->cliente_id = $request->input('cliente_id');
        $venta->save();

        return response()->json(['t' => 'success', 'm' => '¡Hecho!<br>Cliente actualizado correctamente']);
    }

    public function bcliente(Request $request){
        $data=[];
        if($request->has('q')){
            $search = $request->get('q');
            $data = Cliente::select('id', 'razon_social')
                ->where('razon_social', 'like', '%'.$search.'%')
                ->orWhere('ndocumento', 'like', '%'.$search.'%')
                ->get();
        }
        return response()->json($data);
    }
}
