<?php

use App\Livewire\Despacho\Dashboard;
use App\Livewire\Despacho\Despachar;
use App\Livewire\Despacho\Pedidos;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('despacho')->middleware('can:despacho');
Route::get('/pedidos', Pedidos::class)->name('despacho.pedidos')->middleware('can:despacho.pedidos');
Route::get('/pedidos/despachar', Despachar::class)->name('despacho.pedidos.despachar')->middleware('can:despacho.pedidos.despachar');
