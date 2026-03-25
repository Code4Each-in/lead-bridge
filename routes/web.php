<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('/dashboard', DashboardController::class);
});


Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::get('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
