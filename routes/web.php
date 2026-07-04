<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TentangController;

Route::get('/tentang', [TentangController::class, 'index'])
    ->name('tentang');

// ==========================
// Public (Guest)
// ==========================

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::view('/hubungi', 'hubungi')->name('hubungi');

// ==========================
// Dashboard
// ==========================

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

// ==========================
// Profile
// ==========================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
