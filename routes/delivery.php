<?php

use App\Livewire\Delivery\Dashboard;
use App\Livewire\Delivery\Detalle;
use App\Livewire\Delivery\Entregar;
use App\Livewire\Delivery\MisEntregas;
use App\Livewire\Delivery\Pedidos;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('delivery')->middleware('can:delivery');
Route::get('/pedidos', Pedidos::class)->name('delivery.pedidos')->middleware('can:delivery.pedidos');
Route::get('/pedidos/{venta}', Entregar::class)->name('delivery.pedidos.entregar')->middleware('can:delivery.pedidos.entregar');
Route::get('/misentregas', MisEntregas::class)->name('delivery.misentregas')->middleware('can:delivery.misentregas');
Route::get('/misentregas/{venta}', Detalle::class)->name('delivery.misentregas.detalle')->middleware('can:delivery.misentregas');
