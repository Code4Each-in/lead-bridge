<?php

use App\Http\Controllers\AgencyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('/dashboard', DashboardController::class);
});
Route::middleware(['auth', 'active'])->group(function () {
Route::get('/users', [UserController::class, 'index']);
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
});
Route::middleware(['auth','active'])->group(function () {
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::get('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
});
Route::post('users/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware('auth')->group(function () {
    Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies.index');
    Route::post('/agencies/store', [AgencyController::class, 'store'])->name('agencies.store');
    Route::post('/agencies/update/{id}', [AgencyController::class, 'update'])->name('agencies.update');
    Route::get('/agencies/delete/{id}', [AgencyController::class, 'destroy'])->name('agencies.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/leads',[LeadController::class, 'index'])->name('leads.index');
    Route::post('/leads',[LeadController::class, 'store'])->name('leads.store');
    Route::post('/leads/{id}/update',[LeadController::class, 'update'])->name('leads.update');
    Route::get('/leads/{id}/delete',[LeadController::class, 'destroy'])->name('leads.delete');

});
