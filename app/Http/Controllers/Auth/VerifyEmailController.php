<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;

class VerifyEmailController extends Controller
{


    /**
     * Verifikasi email pengguna tanpa perlu login terlebih dahulu.
     */
    public function __invoke(Request $request): RedirectResponse
    {

        /*
        |--------------------------------------------------------------------------
        | Validasi Signed URL
        |--------------------------------------------------------------------------
        */
        if (! URL::hasValidSignature($request)) {
            abort(403, 'Link verifikasi tidak valid atau telah kedaluwarsa.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cari User
        |--------------------------------------------------------------------------
        */
        $user = User::findOrFail($request->route('id'));

        /*
        |--------------------------------------------------------------------------
        | Validasi Hash Email
        |--------------------------------------------------------------------------
        */
        if (! hash_equals(
            (string) $request->route('hash'),
            sha1($user->getEmailForVerification())
        )) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        /*
        |--------------------------------------------------------------------------
        | Jika Sudah Diverifikasi
        |--------------------------------------------------------------------------
        */
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with(
                'success',
                'Email Anda sudah berhasil diverifikasi. Silakan login.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Tandai Email Sebagai Terverifikasi
        |--------------------------------------------------------------------------
        */
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect ke Login
        |--------------------------------------------------------------------------
        */
        return redirect()->route('login')->with(
            'success',
            'Email berhasil diverifikasi. Silakan tunggu akun Anda diaktifkan oleh administrator sebelum login.'
        );
    }
}
