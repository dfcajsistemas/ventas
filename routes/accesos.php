<?php

use App\Livewire\Accesos\Dashboard;
use App\Livewire\Accesos\Users;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('accesos');
Route::get('/users', Users::class)->name('accesos.users');
