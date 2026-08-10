<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Setting;
use App\Services\SeoService;

class ContactController extends Controller
{
    public function index(SeoService $seoService)
{
    $setting = Setting::first();

    $seo = $seoService->generate($setting);

    return view('hubungi', compact('seo'));
}

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|max:255',
            'phone'     => 'required|max:20',
            'email'     => 'required|email|max:255',
            'message'   => 'required'
        ]);

        ContactMessage::create([

        'user_id' => Auth::check()
            ? Auth::id()
            : null,

        'full_name' => $request->full_name,

        'email' => $request->email,

        'phone' => $request->phone,

        'message' => $request->message,

    ]);

        return back()->with('success','Pesan berhasil dikirim.');
    }
}
