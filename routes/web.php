<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\FaqController;

Route::get('/hubungi',[ContactController::class,'index'])->name('hubungi');

Route::post('/hubungi',[ContactController::class,'store'])
    ->name('hubungi.store');

Route::get('/tentang', [TentangController::class, 'index'])
    ->name('tentang');

/*
|--------------------------------------------------------------------------
| Menu User
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Berita
    Route::get('/berita', [BeritaController::class, 'index'])
        ->name('berita.index');

    Route::get('/berita/{slug}', [BeritaController::class, 'show'])
        ->name('berita.show');


    // Galeri
    Route::get('/galeri', [GaleriController::class, 'index'])
        ->name('galeri.index');


    // Pertanyaan (FAQ)
    Route::get('/pertanyaan', [FaqController::class, 'index'])
        ->name('faq.index');

});
// ==========================
// Public (Guest)
// ==========================

Route::get('/', [HomeController::class, 'index'])->name('home');

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
