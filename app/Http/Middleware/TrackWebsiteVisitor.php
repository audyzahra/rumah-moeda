<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\WebsiteVisitor;

use Carbon\Carbon;

class TrackWebsiteVisitor
{
    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | Jangan hitung halaman admin
        |--------------------------------------------------------------------------
        */

        if (!$request->is('admin*')) {

            WebsiteVisitor::firstOrCreate(

                [

                    'ip_address' => $request->ip(),

                    'visit_date' => Carbon::today(),

                ],

                [

                    'user_agent' => $request->userAgent()

                ]

            );

        }

        return $next($request);
    }
}
