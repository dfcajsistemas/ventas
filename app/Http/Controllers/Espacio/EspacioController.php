<?php

namespace App\Http\Controllers\Espacio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function modulos()
    {
        return view('espacio.modulos');
    }
    public function datos()
    {
        return view('espacio.datos');
    }
}
