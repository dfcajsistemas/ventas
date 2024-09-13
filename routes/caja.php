<?php

use App\Livewire\Caja\Cajas;
use App\Livewire\Caja\Cobrar;
use App\Livewire\Caja\Dashboard;
use App\Livewire\Caja\Ver;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('caja')->middleware('can:caja');
Route::get('/cajas', Cajas::class)->name('caja.cajas')->middleware('can:caja.cajas');
Route::get('/cajas/{caja}', Ver::class)->name('caja.cajas.ver')->middleware('can:caja.cajas.ver');
