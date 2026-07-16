<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();

        return view(
            'admin.settings.hero-section',
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
            'hero_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        if ($request->hasFile('hero_image')) {

            // Hapus hero lama jika ada
            if (
                !empty($setting->hero_image) &&
                Storage::disk('public')->exists($setting->hero_image)
            ) {
                Storage::disk('public')->delete($setting->hero_image);
            }

            // Simpan hero baru ke storage/app/public/hero
            $path = $request->file('hero_image')->store('hero', 'public');

            // Simpan path ke database
            $setting->hero_image = $path;
        }

        $setting->save();

        return redirect()
            ->route('admin.settings.hero.index')
            ->with('success', 'Hero berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
