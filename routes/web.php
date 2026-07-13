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
use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrganizationStructureController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\PartnerController;

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
| Public Content
|--------------------------------------------------------------------------
*/

// Berita
Route::get('/berita', [BeritaController::class, 'index'])
    ->name('berita.index');

Route::get('/berita/{slug}', [BeritaController::class, 'show'])
    ->name('berita.show');

// Galeri
Route::get('/galeri', [GalleryController::class, 'index'])
    ->name('galeri.index');

// FAQ
Route::get('/pertanyaan', [FaqController::class, 'index'])
    ->name('faq.index');


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Simpan Berita (sementara)
    Route::post('/berita/store', [BeritaController::class, 'store'])
        ->name('berita.store');

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

require __DIR__ . '/auth.php';

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
        | Mitra
        |--------------------------------------------------------------------------
        */

        Route::resource('mitra', PartnerController::class);

        /*
        |--------------------------------------------------------------------------
        | Aspirasi
        |--------------------------------------------------------------------------
        */

        Route::get('/aspirasi', [AspirasiController::class, 'index'])
            ->name('aspirasi.index');

        Route::put('/aspirasi/{aspirasi}/read', [AspirasiController::class, 'markAsRead'])
            ->name('aspirasi.read');

        Route::delete('/aspirasi/{aspirasi}', [AspirasiController::class, 'destroy'])
            ->name('aspirasi.destroy');

        Route::delete('/aspirasi', [AspirasiController::class, 'bulkDelete'])
            ->name('aspirasi.bulkDelete');

        /*
        |--------------------------------------------------------------------------
        | Berita
        |--------------------------------------------------------------------------
        */

        Route::get('/berita', [NewsController::class, 'index'])
            ->name('berita.index');

        Route::post('/berita', [NewsController::class, 'store'])
            ->name('berita.store');

        Route::put('/berita/{id}', [NewsController::class, 'update'])
            ->name('berita.update');

        Route::delete('/berita/{id}', [NewsController::class, 'destroy'])
            ->name('berita.destroy');

        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        Route::get('/gallery', [AdminGalleryController::class, 'index'])
            ->name('gallery.index');

        Route::post('/gallery', [AdminGalleryController::class, 'store'])
            ->name('gallery.store');

        Route::put('/gallery/{gallery}', [AdminGalleryController::class, 'update'])
            ->name('gallery.update');

        Route::delete('/gallery/{gallery}', [AdminGalleryController::class, 'destroy'])
            ->name('gallery.destroy');

        /*
        |--------------------------------------------------------------------------
        | FAQ
        |--------------------------------------------------------------------------
        */

        Route::get('/faq', [AdminFaqController::class, 'index'])
            ->name('faq.index');

        Route::post('/faq', [AdminFaqController::class, 'store'])
            ->name('faq.store');

        Route::put('/faq/{faq}', [AdminFaqController::class, 'update'])
            ->name('faq.update');

        Route::delete('/faq/{faq}', [AdminFaqController::class, 'destroy'])
            ->name('faq.destroy');

    });
