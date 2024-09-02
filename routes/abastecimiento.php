<?php

use App\Livewire\Abastecimiento\Dashboard;
use App\Livewire\Abastecimiento\Productos;
use App\Livewire\Abastecimiento\Reposiciones;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('abastecimiento')->middleware('can:abastecimiento');
Route::get('/productos', Productos::class)->name('abastecimiento.productos')->middleware('can:abastecimiento.productos');
Route::get('/productos/{producto}', Reposiciones::class)->name('abastecimiento.productos.reposiciones')->middleware('can:abastecimiento.productos.reposiciones');
