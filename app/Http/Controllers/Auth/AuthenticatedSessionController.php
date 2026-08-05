<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Cek Email Verification
    |--------------------------------------------------------------------------
    */
    if (! $user->hasVerifiedEmail()) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'Email Anda belum diverifikasi. Silakan cek email Anda untuk melakukan verifikasi.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cek Status Akun
    |--------------------------------------------------------------------------
    */
    if (! $user->status) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator untuk informasi lebih lanjut.',
        ]);
    }

    $request->session()->regenerate();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
