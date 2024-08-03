<?php

use App\Livewire\Mantenimiento\Categorias;
use App\Livewire\Mantenimiento\Dashboard;
use App\Livewire\Mantenimiento\Productos;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('mantenimiento')->middleware('can:mantenimiento');
Route::get('/categorias', Categorias::class)->name('mantenimiento.categorias')->middleware('can:mantenimiento.categorias');
Route::get('/productos', Productos::class)->name('mantenimiento.productos')->middleware('can:mantenimiento.productos');
