<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

use App\Models\Setting;
use App\Models\ContactMessage;

use Illuminate\Support\Facades\Schema;

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
        Paginator::useBootstrapFive();

        View::share('setting', Setting::first());

        $jumlahNotifSidebar = 0;

        if (Schema::hasTable('contact_messages')) {
            $jumlahNotifSidebar = ContactMessage::where('is_read', 0)->count();
        }

        View::share('jumlahNotifSidebar', $jumlahNotifSidebar);
    }
}
