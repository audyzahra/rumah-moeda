<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Documentation;
use App\Models\ContactMessage;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Pengaturan Website
        $setting = Setting::first();

        // Total berita milik user
        $totalNews = News::where(
            'author_id',
            $user->id
        )->count();

        // Total dokumentasi milik user
        $totalDocumentation = Documentation::where(
            'author_id',
            $user->id
        )->count();

        // Total aspirasi milik user
        $totalAspirasi = ContactMessage::where(
            'email',
            $user->email
        )->count();

        return view(
            'user.dashboard.index',
            compact(
                'setting',
                'totalNews',
                'totalDocumentation',
                'totalAspirasi'
            )
        );
    }
}
