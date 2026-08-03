<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyProfileController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
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
        $setting = Setting::first();

        $request->validate([
            'website_name' => 'required|string|max:255',

            'website_logo' => [
                Rule::requiredIf(!$setting || empty($setting->website_logo)),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,svg,webp',
                'max:2048',
            ],

            'website_description' => 'required|string',

            'phone_number' => 'required|string|max:50',

            'email' => 'required|email|max:255',

            'fax_number' => 'nullable|string|max:50',

            'address' => 'required|string',

            'instagram_url' => 'required|url|max:255',

            'facebook_url' => 'nullable|url|max:255',

            'tiktok_url' => 'nullable|url|max:255',

        ], [
            'website_name.required' => 'Nama website wajib diisi.',

            'website_logo.required' => 'Logo website wajib diupload.',
            'website_logo.image' => 'Logo harus berupa gambar.',
            'website_logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, SVG atau WEBP.',
            'website_logo.max' => 'Ukuran logo maksimal 2 MB.',

            'website_description.required' => 'Deskripsi website wajib diisi.',

            'phone_number.required' => 'Nomor telepon wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'address.required' => 'Alamat wajib diisi.',

            'instagram_url.required' => 'URL Instagram wajib diisi.',
            'instagram_url.url' => 'URL Instagram tidak valid.',

            'facebook_url.url' => 'URL Facebook tidak valid.',
            'tiktok_url.url' => 'URL TikTok tidak valid.',
        ]);

        try {

            $websiteName = $this->security->cleanText($request->website_name);

            $websiteDescription = $this->security->cleanHtml($request->website_description);

            $phoneNumber = $this->security->cleanText($request->phone_number);

            $email = $this->security->cleanText($request->email);

            $address = $this->security->cleanText($request->address);

            $faxNumber = !empty($request->fax_number)
                ? $this->security->cleanText($request->fax_number)
                : null;

            $instagram = $this->security->cleanUrl($request->instagram_url);

            $facebook = !empty($request->facebook_url)
                ? $this->security->cleanUrl($request->facebook_url)
                : null;

            $tiktok = !empty($request->tiktok_url)
                ? $this->security->cleanUrl($request->tiktok_url)
                : null;

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }

        if (!$setting) {
            $setting = new Setting();
        }

        if ($request->hasFile('website_logo')) {

            if (
                $setting->website_logo &&
                Storage::disk('public')->exists($setting->website_logo)
            ) {
                Storage::disk('public')->delete($setting->website_logo);
            }

            $setting->website_logo = $request->file('website_logo')
                ->store('logo', 'public');
        }

        $setting->website_name = $websiteName;
        $setting->website_description = $websiteDescription;
        $setting->phone_number = $phoneNumber;
        $setting->email = $email;
        $setting->fax_number = $faxNumber;
        $setting->address = $address;
        $setting->instagram_url = $instagram;
        $setting->facebook_url = $facebook;
        $setting->tiktok_url = $tiktok;

        $setting->save();

        return redirect()
            ->route('admin.settings.profile.index')
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
