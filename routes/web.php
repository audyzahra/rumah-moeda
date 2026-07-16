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
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrganizationStructureController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\VisionMissionController;
use App\Http\Controllers\Admin\UserManagementController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\User\GalleryController as UserGalleryController;
use App\Http\Controllers\User\MessageController as UserMessageController;

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

Route::get('/galeri/foto', [GalleryController::class, 'foto'])
    ->name('galeri.foto');

Route::get('/galeri/video', [GalleryController::class, 'video'])
    ->name('galeri.video');

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

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('user.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | News
        |--------------------------------------------------------------------------
        */

        Route::resource('news', UserNewsController::class);

        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        Route::resource('gallery', UserGalleryController::class);

        /*
        |--------------------------------------------------------------------------
        | Messages
        |--------------------------------------------------------------------------
        */

        Route::get('/messages', [UserMessageController::class, 'index'])
            ->name('messages.index');

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
        | Sidebar Notification (AJAX)
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/sidebar-notification',
            [DashboardController::class, 'sidebarNotification']
        )->name('sidebar.notification');

        /*
        |--------------------------------------------------------------------------
        | Pengaturan
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings');
        // Hero Section
            Route::get('/settings/hero-section', [HeroSectionController::class, 'index'])
                ->name('settings.hero.index');

            // Profil Perusahaan
            Route::get('/settings/company-profile', [CompanyProfileController::class, 'index'])
                ->name('settings.profile.index');

            // Visi Misi
            Route::get('/settings/vision-mission', [VisionMissionController::class, 'index'])
                ->name('settings.visi.index');

        Route::post('/settings/vision-mission', [VisionMissionController::class, 'update'])
            ->name('visi.update');

        Route::post('/settings/logo', [SettingsController::class, 'updateLogo'])
            ->name('logo.update');

        Route::post('/settings/profile', [CompanyProfileController::class, 'update'])
            ->name('profile.update');

        Route::post('/settings/hero', [HeroSectionController::class, 'update'])
            ->name('hero.update');

        Route::post('/settings/user', [SettingsController::class, 'storeUser'])
            ->name('user.store');

        Route::put('/settings/user/{user}', [SettingsController::class, 'updateUser'])
            ->name('user.update');

        Route::delete('/settings/user/{user}', [SettingsController::class, 'destroyUser'])
            ->name('user.delete');

        /*
        |--------------------------------------------------------------------------
        | Struktur Organisasi
        |--------------------------------------------------------------------------
        */
        Route::post('organization-structures/import', [OrganizationStructureController::class, 'import'])
                ->name('organization-structures.import');
        Route::get('organization-structures/export', [OrganizationStructureController::class, 'export'])
                ->name('organization-structures.export');

        Route::resource('organization-structures', OrganizationStructureController::class);

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

        // Tambah Berita
        Route::get('/berita/tambah', [NewsController::class, 'create'])
            ->name('berita.create');

        // Simpan Berita
        Route::post('/berita', [NewsController::class, 'store'])
            ->name('berita.store');

        // Halaman Edit
        Route::get('/berita/{id}/edit', [NewsController::class, 'edit'])
            ->name('berita.edit');

        // Update
        Route::put('/berita/{id}', [NewsController::class, 'update'])
            ->name('berita.update');

        // Hapus
        Route::delete('/berita/{id}', [NewsController::class, 'destroy'])
            ->name('berita.destroy');

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        Route::prefix('kategori')
            ->name('kategori.')
            ->group(function () {

                Route::get('/', [CategoryController::class, 'index'])
                    ->name('index');

                Route::get('/tambah', [CategoryController::class, 'create'])
                    ->name('create');

                Route::post('/', [CategoryController::class, 'store'])
                    ->name('store');

                Route::get('/{id}', [CategoryController::class, 'show'])
                    ->name('show');

                Route::get('/{id}/edit', [CategoryController::class, 'edit'])
                    ->name('edit');

                Route::put('/{id}', [CategoryController::class, 'update'])
                    ->name('update');

                Route::delete('/{id}', [CategoryController::class, 'destroy'])
                    ->name('destroy');

            });
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

        Route::delete('gallery/media/{media}', [AdminGalleryController::class, 'destroyMedia'])->name('gallery.media.destroy');

        Route::get('/gallery/create', [AdminGalleryController::class, 'create'])
            ->name('gallery.create');

        Route::get('/gallery/{gallery}/edit', [AdminGalleryController::class, 'edit'])
                ->name('gallery.edit');
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

    /*
        |--------------------------------------------------------------------------
        | Kelola Akun
        |--------------------------------------------------------------------------
        */
        Route::get('/manage-account', [UserManagementController::class, 'index'])
            ->name('manage-account.index');

        Route::get('/manage-account/create', [UserManagementController::class, 'create'])
        ->name('manage-account.create');

        Route::get('/manage-account/{user}/edit', [UserManagementController::class, 'edit'])
        ->name('manage-account.edit');

        Route::post('/manage-account', [UserManagementController::class, 'store'])
        ->name('manage-account.store');

        Route::put('/manage-account/{user}', [UserManagementController::class, 'update'])
            ->name('manage-account.update');

        Route::delete('/manage-account/{user}', [UserManagementController::class, 'destroy'])
            ->name('manage-account.destroy');

    });
