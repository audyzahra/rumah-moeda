<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::share('setting', Setting::first());

        if (
            Schema::hasTable('contact_messages') &&
            Schema::hasColumn('contact_messages', 'notif_sidebar')
        ) {

            View::share(
                'jumlahNotifSidebar',
                ContactMessage::where('notif_sidebar', 0)->count()
            );

        } else {

            View::share('jumlahNotifSidebar', 0);

        }
    }
}
