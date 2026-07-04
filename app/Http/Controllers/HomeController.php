<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;
use App\Models\OrganizationStructure;
use App\Models\News;
use App\Models\Documentation;


class HomeController extends Controller
{
    public function index()
    {
        // Visi & Misi
        $vision = VisionMission::with('missions')->first();

        // Struktur organisasi
        $organizations = OrganizationStructure::orderBy('display_order')->get();

        // Artikel terbaru
        $news = News::latest('publish_date')
                    ->take(3)
                    ->get();

        // Dokumentasi
        $documentations = Documentation::latest()
                            ->take(5)
                            ->get();

        return view('home', compact(
            'vision',
            'organizations',
            'news',
            'documentations'
        ));
    }
}
