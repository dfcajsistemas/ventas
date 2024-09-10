<?php

use App\Http\Controllers\Despacho\CanastaController;
use App\Livewire\Despacho\Dashboard;
use App\Livewire\Despacho\Elegir;
use App\Livewire\Despacho\Pedidos;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('despacho')->middleware('can:despacho');
Route::get('/pedidos', Pedidos::class)->name('despacho.pedidos')->middleware('can:despacho.pedidos');
Route::get('/pedidos/{venta}', [CanastaController::class, 'canasta'])->name('despacho.pedidos.canasta')->middleware('can:despacho.pedidos.canasta');
