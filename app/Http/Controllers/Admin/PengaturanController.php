<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\VisionMission;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $vision = VisionMission::first();

        $missions = Mission::orderBy('display_order')->get();

        $users = User::orderBy('id')->get();

        return view('admin.pengaturan.pengaturan', compact(
            'setting',
            'vision',
            'missions',
            'users'
        ));
    }
    public function updateVisiMisi(Request $request)
{
    $request->validate([
        'vision' => 'required',
        'missions' => 'required|array',
        'missions.*' => 'required'
    ]);

    $vision = VisionMission::first();

    if (!$vision) {
        $vision = new VisionMission();
    }

    $vision->vision = $request->vision;
    $vision->save();

    Mission::where('vision_mission_id', $vision->id)->delete();

    foreach ($request->missions as $index => $mission) {

        Mission::create([
            'vision_mission_id' => $vision->id,
            'mission' => $mission,
            'display_order' => $index + 1,
        ]);

    }


    return redirect()
        ->route('admin.pengaturan')
        ->with('success', 'Visi dan Misi berhasil diperbarui.');
}
    public function updateLogo(Request $request)
{
    $request->validate([
        'website_logo' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
    ]);

    $setting = Setting::first();

    if (!$setting) {
        return back()->with('error', 'Data pengaturan tidak ditemukan.');
    }

    if ($request->hasFile('website_logo')) {

        // Hapus logo lama jika ada
        if (
            $setting->website_logo &&
            File::exists(public_path($setting->website_logo))
        ) {
            File::delete(public_path($setting->website_logo));
        }

        // Upload logo baru
        $file = $request->file('website_logo');

        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move(
            public_path('uploads'),
            $filename
        );

        // Simpan path ke database
        $setting->update([
            'website_logo' => 'uploads/' . $filename,
        ]);
    }

    return redirect()
        ->route('admin.pengaturan')
        ->with('success', 'Logo berhasil diperbarui.');
}
    public function updateProfile(Request $request)
    {
        $request->validate([
            'website_name' => 'required|max:255',
            'website_description' => 'nullable',
            'phone_number' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'fax_number' => 'nullable|max:50',
            'address' => 'nullable',
            'instagram_url' => 'nullable|max:255',
            'facebook_url' => 'nullable|max:255',
            'tiktok_url' => 'nullable|max:255',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->website_name = $request->website_name;
        $setting->website_description = $request->website_description;
        $setting->phone_number = $request->phone_number;
        $setting->email = $request->email;
        $setting->fax_number = $request->fax_number;
        $setting->address = $request->address;
        $setting->instagram_url = $request->instagram_url;
        $setting->facebook_url = $request->facebook_url;
        $setting->tiktok_url = $request->tiktok_url;

        $setting->save();

        return redirect()
            ->route('admin.pengaturan')
            ->with('success', 'Profile perusahaan berhasil diperbarui.');
    }
    public function updateHero(Request $request)
    {
        $request->validate([
            'hero_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        if ($request->hasFile('hero_image')) {

            // hapus gambar lama
            if (
                $setting->hero_image &&
                file_exists(public_path($setting->hero_image))
            ) {
                unlink(public_path($setting->hero_image));
            }

            $file = $request->file('hero_image');

            $filename = time().'_'.$file->getClientOriginalName();

            // simpan ke public/assets/hero
            $file->move(public_path('assets/hero'), $filename);

            // simpan path ke database
            $setting->hero_image = 'assets/hero/'.$filename;
        }

        $setting->save();

        return redirect()
            ->route('admin.pengaturan')
            ->with('success', 'Hero berhasil diperbarui.');
    }
    public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:admin,user',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return back()->with('success', 'Akun berhasil ditambahkan.');
}
    public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',

        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($user->id),
        ],

        'role' => 'required|in:admin,user',

        'password' => 'nullable|min:8',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {

        $user->password = Hash::make($request->password);

    }

    $user->save();

    return back()->with('success', 'Akun berhasil diperbarui.');
}
    public function destroyUser(User $user)
{
    if ($user->id == auth()->id()) {

        return back()->with('error', 'Tidak dapat menghapus akun sendiri.');

    }

    $user->delete();

    return back()->with('success', 'Akun berhasil dihapus.');
}
}

