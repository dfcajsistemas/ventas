<?php

use App\Livewire\Caja\Cajas;
use App\Livewire\Caja\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('caja')->middleware('can:caja');
Route::get('/cajas', Cajas::class)->name('caja.cajas')->middleware('can:caja.cajas');
