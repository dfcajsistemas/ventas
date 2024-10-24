<?php

namespace App\Http\Controllers\Despacho;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Dventa;
use App\Models\Eventa;
use App\Models\Serie;
use App\Models\Tcomprobante;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanastaController extends Controller
{


    public function canasta(Venta $venta)
    {
        $sucursal = auth()->user()->sucursal;
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

    public function bcliente(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->get('q');
            $data = Cliente::select('id', 'razon_social')
                ->where('razon_social', 'like', '%' . $search . '%')
                ->orWhere('ndocumento', 'like', '%' . $search . '%')
                ->get();
        }
        return response()->json($data);
    }

    public function fPedido(Venta $venta)
    {
        $tcomprobante_id = Tcomprobante::where('codigo', 'TK')->first()->id;
        $serie = Serie::where('sucursal_id', auth()->user()->sucursal->id)->where('tcomprobante_id', $tcomprobante_id)->first();
        //obtenemos el correlativo
        $correlativo = $serie->correlativo + 1;
        //calculamos los montos de operaciones grabadas, exoneradas e inafectas
        $afectaciones = Dventa::join('productos', 'dventas.producto_id', '=', 'productos.id')
            ->join('igvafectacions', 'productos.igvafectacion_id', '=', 'igvafectacions.id')
            ->join('igvporcientos', 'productos.igvporciento_id', '=', 'igvporcientos.id')
            ->select('dventas.id', 'dventas.total', 'igvafectacions.codigo', 'igvporcientos.porcentaje')
            ->where('dventas.venta_id', $venta->id)
            ->get();
        $g = 0;
        $e = 0;
        $i = 0;
        $gigv = 0;
        foreach ($afectaciones as $afectacion) {
            if ($afectacion->codigo == '10') {
                $gigv += $afectacion->total;
                $g += $afectacion->total / (1 + ($afectacion->porcentaje / 100));
            } elseif ($afectacion->codigo == '20') {
                $e += $afectacion->total;
            } elseif ($afectacion->codigo == '30') {
                $i += $afectacion->total;
            }
        }

        try {
            DB::beginTransaction();
            //actualizamos la venta y la serie del ticket
            $venta->update([
                'ser_ticket' => $serie->serie,
                'cor_ticket' => $correlativo,
                'op_grabada' => number_format($g, 6),
                'op_exonerada' => $e,
                'op_inafecta' => $i,
                'igv' => number_format(($gigv - $g), 6),
                'total' => $gigv + $e + $i,
                'est_venta' => 1,
                'updated_by' => auth()->user()->id
            ]);
            //actualizamos el correlativo de la serie
            $serie->update([
                'correlativo' => $correlativo,
                'updated_by' => auth()->user()->id
            ]);
            //creamos el estado de venta
            Eventa::create([
                'venta_id' => $venta->id,
                'est_venta' => 1,
                'user_id' => auth()->user()->id
            ]);
            DB::commit();
            return redirect()->route('despacho.pedidos.canasta', $venta->id)->with('success', '¡Hecho!<br>Pedido generado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('despacho.pedidos.canasta', $venta->id)->with('error', '¡Error!<br>Hubo un problema al generar el pedido');
        }
    }
}
