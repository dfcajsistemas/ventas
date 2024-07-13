<?php

use App\Livewire\Accesos\Dashboard;
use App\Livewire\Accesos\Permisos;
use App\Livewire\Accesos\Roles;
use App\Livewire\Accesos\RolesPermisos;
use App\Livewire\Accesos\Users;
use App\Livewire\Accesos\UsersRoles;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('accesos')->middleware('can:accesos');

Route::get('/users', Users::class)->name('accesos.users')->middleware('can:accesos.users');
Route::get('/users/{user}', UsersRoles::class)->name('accesos.users.roles')->middleware('can:accesos.users.roles');

Route::get('/roles', Roles::class)->name('accesos.roles')->middleware('can:accesos.roles');
Route::get('/roles/{role}', RolesPermisos::class)->name('accesos.roles.permisos')->middleware('can:accesos.roles.permisos');

Route::get('/permisos', Permisos::class)->name('accesos.permisos')->middleware('can:accesos.permisos');
