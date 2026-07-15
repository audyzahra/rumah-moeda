<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;
use App\Models\OrganizationStructure;
use App\Models\News;
use App\Models\Gallery;
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
        $organizations = OrganizationStructure::with('childrenRecursive')
                    ->whereNull('parent_id')
                    ->orderBy('full_name')
                    ->get();

        // Artikel terbaru
        $news = News::latest('publish_date')
                    ->take(3)
                    ->get();

        // Galeri
        $gallery = Gallery::with('media')
            ->latest()
            ->take(10)
            ->get();

        $videos = collect();
        $photos = collect();

        foreach ($gallery as $item) {
            foreach ($item->media as $media) {
                if ($media->type == 'video' && $videos->count() < 1) {
                    $videos->push($media);
                }

                if ($media->type == 'image' && $photos->count() < 4) {
                    $photos->push($media);
                }
            }

            if ($videos->count() >= 1 && $photos->count() >= 4) {
                break;
            }
        }
        // Partners
        $partners = Partner::orderBy('display_order')->get();

        return view('home', compact(
            'vision',
            'organizations',
            'news',
            'videos',
            'photos',
            'partners',
            'setting'
        ));
    }
}
