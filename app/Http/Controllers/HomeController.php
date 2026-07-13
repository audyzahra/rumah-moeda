<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;
use App\Models\OrganizationStructure;
use App\Models\News;
use App\Models\Documentation;
use App\Models\Partner;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        // Hero Section
        $setting = Setting::first();
        // Visi & Misi
        $vision = VisionMission::with('missions')->first();

        // Struktur organisasi
        $organizations = OrganizationStructure::orderBy('parent_id')
        ->orderBy('full_name')
        ->get();

        // Artikel terbaru
        $news = News::latest('publish_date')
                    ->take(3)
                    ->get();

        // Dokumentasi
        $documentations = Documentation::latest()
                            ->take(5)
                            ->get();

        // Partners
        $partners = Partner::orderBy('display_order')->get();

        return view('home', compact(
            'vision',
            'organizations',
            'news',
            'documentations',
            'partners',
            'setting'
        ));
    }
}
