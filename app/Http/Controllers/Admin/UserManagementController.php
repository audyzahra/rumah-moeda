<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;

class UserManagementController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::latest()->paginate(5);

        return view('admin.kelola.kelola-akun', compact('users'));
    }

    public function create()
    {
        return view('admin.kelola.create');
    }

    public function edit(User $user)
    {
        return view('admin.kelola.edit', compact('user'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'status' => 'required|boolean',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'role.required' => 'Role wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
        ]);
        try {

        $name = $this->security->cleanText($validated['name']);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }
        User::create([
            'name' => $name,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.manage-account.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
            $validated = $request->validate([
        'name' => 'required|string|max:255',

        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id),
        ],

            'role' => 'required|in:admin,user',

            'status' => 'required|boolean',

            'password' => 'nullable|string|min:8|confirmed',

        ],[
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'role.required' => 'Role wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        try {

        $name = $this->security->cleanText($validated['name']);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }
        $user->name = $name;
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.manage-account.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {

            return redirect()
                ->route('admin.manage-account.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.manage-account.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
