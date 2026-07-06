<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Bukan admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
