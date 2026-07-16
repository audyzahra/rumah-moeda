<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();

        return view(
            'admin.settings.profil-perusahaan',
            compact('setting')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
                'website_name' => 'required|max:255',
                'website_logo' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
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

            if ($request->hasFile('website_logo')) {

                // Hapus logo lama jika ada
                if (
                    $setting->website_logo &&
                    Storage::disk('public')->exists($setting->website_logo)
                ) {
                    Storage::disk('public')->delete($setting->website_logo);
                }

                // Upload logo baru
                $path = $request->file('website_logo')
                                ->store('logo', 'public');

                // Simpan path logo
                $setting->website_logo = $path;
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
                ->route('admin.settings.profile.index')
                ->with('success', 'Profile perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
