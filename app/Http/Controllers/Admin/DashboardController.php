<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Gallery;
use App\Models\News;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalPartner = Partner::count();

        $totalNews = News::count();

        $totalGallery = Gallery::count();

        $totalAspirasi = ContactMessage::count();

        $aspirasiBaru = ContactMessage::where('is_read', 0)->count();

        $beritaBaru = News::whereDate(
            'created_at',
            today()
        )->count();

        $galleryBaru = Gallery::whereDate(
            'created_at',
            today()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Aspirasi Terbaru (3 Data)
        |--------------------------------------------------------------------------
        */

        $latestMessages = ContactMessage::latest()
            ->take(3)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Berita Terpopuler
        |--------------------------------------------------------------------------
        */

        $popularNews = News::with(['category', 'author'])
            ->orderByDesc('views')
            ->latest()
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'totalPartner',
            'totalNews',
            'totalGallery',
            'totalAspirasi',
            'aspirasiBaru',
            'beritaBaru',
            'galleryBaru',
            'latestMessages',
            'popularNews'
        ));
    }
}
