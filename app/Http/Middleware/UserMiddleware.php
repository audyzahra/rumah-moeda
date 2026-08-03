<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role !== 'user') {
        return response()
            ->view('errors.403', [
                'redirect' => route('admin.dashboard')
            ], 403);
    }

    return $next($request);
}
}
