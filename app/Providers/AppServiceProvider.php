<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Setting;
use App\Models\ContactMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Setting Website
        View::share('setting', Setting::first());

        // Jumlah notifikasi sidebar aspirasi
        View::share(
            'jumlahNotifSidebar',
            ContactMessage::where('notif_sidebar', 0)->count()
        );
    }
}
