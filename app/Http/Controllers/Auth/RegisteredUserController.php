<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    'unique:' . User::class,
                ],

                'password' => [
                    'required',
                    'confirmed',

                    Password::min(8)
                        ->mixedCase()   // Huruf besar & kecil
                        ->numbers()     // Angka
                        ->symbols(),    // Simbol
                ],
            ],
            [
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.mixed' => 'Password harus memiliki huruf besar dan huruf kecil.',
                'password.numbers' => 'Password harus mengandung minimal satu angka.',
                'password.symbols' => 'Password harus mengandung minimal satu simbol.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
