<?php

use App\Livewire\Reportes\Dashboard;
use App\Livewire\Reportes\Ventas;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('reportes')->middleware('can:reportes');
Route::get('/ventas', Ventas::class)->name('reportes.ventas')->middleware('can:reportes.ventas');
