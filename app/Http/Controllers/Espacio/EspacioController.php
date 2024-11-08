<?php

namespace App\Http\Controllers\Espacio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function modulos()
    {
        $sucursal = auth()->user()->sucursal;
        return view('espacio.modulos', compact('sucursal'));
    }
    public function datos()
    {
        return view('espacio.datos');
    }
}
