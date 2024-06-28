<?php

use App\Http\Controllers\Espacio\EspacioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EspacioController::class, 'modulos'])->name('espacio');
Route::get('datos', [EspacioController::class, 'datos'])->name('espacio.datos');
