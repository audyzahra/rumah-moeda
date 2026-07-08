<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\OrganizationStructureController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
// use App\Http\Controllers\Admin\NewsController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang', [TentangController::class, 'index'])
    ->name('tentang');

Route::get('/hubungi', [ContactController::class, 'index'])
    ->name('hubungi');

Route::post('/hubungi', [ContactController::class, 'store'])
    ->name('hubungi.store');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Berita
    Route::get('/berita', [BeritaController::class, 'index'])
        ->name('berita.index');

    Route::get('/berita/{slug}', [BeritaController::class, 'show'])
        ->name('berita.show');

    Route::post('/berita/store', [BeritaController::class, 'store'])
        ->name('berita.store');

    // Gallery
    Route::get('/galeri', [GalleryController::class, 'index'])
        ->name('galeri.index');

    // FAQ
    Route::get('/pertanyaan', [FaqController::class, 'index'])
        ->name('faq.index');

});

/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/logout-login', function () {

        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');

    })->name('logout.login');

});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Pengaturan
        |--------------------------------------------------------------------------
        */

        Route::get('/pengaturan', [PengaturanController::class, 'index'])
            ->name('pengaturan');

        Route::post('/pengaturan/visi-misi', [PengaturanController::class, 'updateVisiMisi'])
            ->name('visimisi.update');

        Route::post('/pengaturan/logo', [PengaturanController::class, 'updateLogo'])
            ->name('logo.update');

        Route::post('/pengaturan/profile', [PengaturanController::class, 'updateProfile'])
            ->name('profile.update');

        Route::post('/pengaturan/hero', [PengaturanController::class, 'updateHero'])
            ->name('hero.update');

        Route::post('/pengaturan/user', [PengaturanController::class, 'storeUser'])
            ->name('user.store');

        Route::put('/pengaturan/user/{user}', [PengaturanController::class, 'updateUser'])
            ->name('user.update');

        Route::delete('/pengaturan/user/{user}', [PengaturanController::class, 'destroyUser'])
            ->name('user.delete');

        /*
        |--------------------------------------------------------------------------
        | Struktur Organisasi
        |--------------------------------------------------------------------------
        */

        Route::resource('struktur', OrganizationStructureController::class);

        /*
        |--------------------------------------------------------------------------
        | Menu Admin
        |--------------------------------------------------------------------------
        */

        // Aspirasi
        Route::view('/aspirasi', 'admin.aspirasi.aspirasi')
            ->name('aspirasi.index');

        // // Berita
        // Route::get('/berita', [NewsController::class, 'index'])
        //         ->name('berita.index');

        // Route::post('/berita', [NewsController::class, 'store'])
        //     ->name('berita.store');

        // Route::put('/berita/{id}', [NewsController::class, 'update'])
        //     ->name('berita.update');

        // Route::delete('/berita/{id}', [NewsController::class, 'destroy'])
        //     ->name('berita.destroy');

        // Gallery
        Route::get('/gallery', [AdminGalleryController::class, 'index'])
        ->name('gallery.index');

        Route::post('/gallery', [AdminGalleryController::class, 'store'])
            ->name('gallery.store');

        Route::put('/gallery/{gallery}', [AdminGalleryController::class, 'update'])
            ->name('gallery.update');

        Route::delete('/gallery/{gallery}', [AdminGalleryController::class, 'destroy'])
            ->name('gallery.destroy');
            
        // Mitra
        Route::view('/mitra', 'admin.mitra.mitra')
            ->name('mitra.index');

        // FAQ
        Route::view('/faq', 'admin.faq.faq')
            ->name('faq.index');

    });
