<?php

use App\Livewire\Reportes\CuentasCobrar;
use App\Livewire\Reportes\Dashboard;
use App\Livewire\Reportes\FlujoCajas;
use App\Livewire\Reportes\Inventario;
use App\Livewire\Reportes\VentaProductos;
use App\Livewire\Reportes\Ventas;
use App\Livewire\Reportes\VentasCliente;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('reportes')->middleware('can:reportes');
Route::get('/ventas', Ventas::class)->name('reportes.ventas')->middleware('can:reportes.ventas');
Route::get('/cuentas-cobrar', CuentasCobrar::class)->name('reportes.cuentascobrar')->middleware('can:reportes.cuentascobrar');
Route::get('/inventario', Inventario::class)->name('reportes.inventario')->middleware('can:reportes.inventario');
Route::get('/ventascliente', VentasCliente::class)->name('reportes.ventascliente')->middleware('can:reportes.ventascliente');
Route::get('/flujocajas', FlujoCajas::class)->name('reportes.flujocajas')->middleware('can:reportes.flujocajas');
Route::get('/ventaproductos', VentaProductos::class)->name('reportes.ventaproductos')->middleware('can:reportes.ventaproductos');
