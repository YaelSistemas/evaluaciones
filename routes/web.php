<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::view('/', 'welcome');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ------- ADMIN --------
Route::middleware(['auth','verified'])->group(function () {
    Route::prefix('admin')->name('admin.')->middleware('is.admin')->group(function () {
        // Dashboard Admin propio
        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Usuarios
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle', [UserController::class,'toggle'])->name('users.toggle');
    });
});

require __DIR__.'/auth.php';
