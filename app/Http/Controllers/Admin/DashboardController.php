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
        $totalPartner = Partner::count();

        $totalNews = News::count();

        $totalGallery = Gallery::count();

        $totalAspirasi = ContactMessage::count();

        $aspirasiBaru = ContactMessage::where('is_read',0)->count();

        $beritaBaru = News::whereDate(
            'created_at',
            today()
        )->count();

        $galleryBaru = Gallery::whereDate(
            'created_at',
            today()
        )->count();

        $latestMessages = ContactMessage::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPartner',
            'totalNews',
            'totalGallery',
            'totalAspirasi',
            'aspirasiBaru',
            'beritaBaru',
            'galleryBaru',
            'latestMessages'
        ));
    }
}
