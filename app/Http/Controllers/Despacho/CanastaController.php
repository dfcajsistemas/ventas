<?php

namespace App\Http\Controllers\Despacho;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;

class CanastaController extends Controller
{
    public $sucursal;

    public function __construct()
    {
        $this->sucursal = auth()->user()->sucursal;
    }

    public function canasta(Venta $venta)
    {
        $venta->load('productos');
        return view('despacho.canasta', compact('venta'));
    }
}
