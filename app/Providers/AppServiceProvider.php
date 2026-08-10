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
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            Registered::class,
            SendEmailVerificationNotification::class
        );

        Paginator::useBootstrapFive();

        $setting = null;

        if (Schema::hasTable('settings')) {
            $setting = Setting::first();
        }

        View::share('setting', $setting);

        $totalVisitors = 0;
        $todayVisitors = 0;

        if (Schema::hasTable('website_visitors')) {
            $totalVisitors = WebsiteVisitor::count();

            $todayVisitors = WebsiteVisitor::whereDate(
                'visit_date',
                Carbon::today()
            )->count();
        }

        View::share('totalVisitors', $totalVisitors);
        View::share('todayVisitors', $todayVisitors);

        $jumlahNotifSidebar = 0;

        if (Schema::hasTable('contact_messages')) {
            $jumlahNotifSidebar = ContactMessage::where(
                'is_read',
                0
            )->count();
        }

        View::share('jumlahNotifSidebar', $jumlahNotifSidebar);
    }
}
