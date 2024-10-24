<?php

use App\Http\Controllers\Despacho\CanastaController;
use App\Livewire\Despacho\Dashboard;
use App\Livewire\Despacho\Distribuir;
use App\Livewire\Despacho\Dpedidos;
use App\Livewire\Despacho\Elegir;
use App\Livewire\Despacho\Pedidos;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('despacho')->middleware('can:despacho');
Route::get('/pedidos', Pedidos::class)->name('despacho.gpedidos')->middleware('can:despacho.gpedidos');
Route::put('/pedidos/cliente', [CanastaController::class, 'updateCliente'])->name('despacho.gpedidos.cliente');
Route::get('/pedidos/bcliente', [CanastaController::class, 'bcliente'])->name('despacho.gpedidos.bcliente');

Route::get('/pedidos/{venta}', [CanastaController::class, 'canasta'])->name('despacho.gpedidos.canasta')->middleware('can:despacho.gpedidos.canasta');
Route::get('/pedidos/gpedido/{venta}', [CanastaController::class, 'fPedido'])->name('despacho.gpedidos.fpedido'); //finalizar pedido
Route::get('/pedidos/distribuir/{venta}', Distribuir::class)->name('despacho.pedidos.distribuir')->middleware('can:despacho.pedidos.distribuir');

Route::get('dpedidos', Dpedidos::class)->name('despacho.dpedidos')->middleware('can:despacho.dpedidos');
