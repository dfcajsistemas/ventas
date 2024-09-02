<?php

use App\Livewire\Despacho\Dashboard;
use App\Livewire\Despacho\Despachar;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('despacho')->middleware('can:despacho');
Route::get('/despachar', Despachar::class)->name('despacho.despachar')->middleware('can:despacho.despachar');
