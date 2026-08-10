<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\VisionMission;
use App\Models\OrganizationStructure;

use App\Services\SeoService;

class TentangController extends Controller
{
    public function index(SeoService $seoService)
    {
        $settings = Setting::first();

        $vision = VisionMission::with('missions')->first();

        $organizations = OrganizationStructure::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('full_name')
            ->get();

            // seo
            $seo = $seoService->generate($settings);

        return view('tentang', compact(
            'settings',
            'vision',
            'organizations',
            'seo'
        ));
    }
}
