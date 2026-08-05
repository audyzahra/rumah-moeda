<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

use App\Models\Setting;
use App\Models\ContactMessage;
use App\Models\WebsiteVisitor;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

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
            Event::listen(
            Registered::class,
            SendEmailVerificationNotification::class
        );

        Paginator::useBootstrapFive();
        Paginator::useBootstrapFive();

        View::share('setting', Setting::first());

        // ===========================
        // Total Pengunjung
        // ===========================

        if (Schema::hasTable('website_visitors')) {

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

        } else {

            View::share('totalVisitors', 0);
            View::share('todayVisitors', 0);

        }

        // ===========================
        // Notifikasi Sidebar
        // ===========================

        $jumlahNotifSidebar = 0;

        if (Schema::hasTable('contact_messages')) {

            $jumlahNotifSidebar = ContactMessage::where(
                'is_read',
                0
            )->count();

        }

        View::share(
            'jumlahNotifSidebar',
            $jumlahNotifSidebar
        );
    }
}
