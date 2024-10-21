<?php

use App\Http\Controllers\Espacio\EspacioController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [EspacioController::class, 'modulos'])->name('espacio');
Route::get('datos', [EspacioController::class, 'datos'])->name('espacio.datos');
Route::get('/generar-link', function () {
    Artisan::call('storage:link');
    return "storage-link ejecutado";
});
