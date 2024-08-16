<?php

use App\Livewire\Mantenimiento\Categorias;
use App\Livewire\Mantenimiento\Clientes;
use App\Livewire\Mantenimiento\Dashboard;
use App\Livewire\Mantenimiento\Empresas;
use App\Livewire\Mantenimiento\Mpagos;
use App\Livewire\Mantenimiento\Productos;
use App\Livewire\Mantenimiento\Series;
use App\Livewire\Mantenimiento\Sucursals;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('mantenimiento')->middleware('can:mantenimiento');
Route::get('/categorias', Categorias::class)->name('mantenimiento.categorias')->middleware('can:mantenimiento.categorias');
Route::get('/productos', Productos::class)->name('mantenimiento.productos')->middleware('can:mantenimiento.productos');
Route::get('/empresas', Empresas::class)->name('mantenimiento.empresas')->middleware('can:mantenimiento.empresas');
Route::get('/sucursals', Sucursals::class)->name('mantenimiento.sucursals')->middleware('can:mantenimiento.sucursals');
Route::get('/mpagos', Mpagos::class)->name('mantenimiento.mpagos')->middleware('can:mantenimiento.mpagos');
Route::get('/series', Series::class)->name('mantenimiento.series')->middleware('can:mantenimiento.series');
Route::get('/clientes', Clientes::class)->name('mantenimiento.clientes')->middleware('can:mantenimiento.clientes');
