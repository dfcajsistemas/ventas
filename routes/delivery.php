<?php

use App\Livewire\Delivery\Dashboard;
use App\Livewire\Delivery\Pedidos;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('delivery')->middleware('can:delivery');
Route::get('/pedidos', Pedidos::class)->name('delivery.pedidos')->middleware('can:delivery.pedidos');
