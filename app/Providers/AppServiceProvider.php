<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

use App\Models\Setting;
use App\Models\ContactMessage;

use Illuminate\Support\Facades\Schema;

use App\Models\WebsiteVisitor;

use Carbon\Carbon;

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
        View::share(
            'totalVisitors',
            WebsiteVisitor::count()
        );
        View::share(
            'todayVisitors',
            WebsiteVisitor::whereDate(
                'visit_date',
                Carbon::today()
            )->count()
        );

        $jumlahNotifSidebar = 0;

        if (Schema::hasTable('contact_messages')) {
            $jumlahNotifSidebar = ContactMessage::where('is_read', 0)->count();
        }

        View::share('jumlahNotifSidebar', $jumlahNotifSidebar);
    }
}
