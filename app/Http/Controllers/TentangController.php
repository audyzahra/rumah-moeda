<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\VisionMission;
use App\Models\OrganizationStructure;

class TentangController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        $vision = VisionMission::with('missions')->first();

        $organizations = OrganizationStructure::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('full_name')
            ->get();

        return view('tentang', compact(
            'settings',
            'vision',
            'organizations'
        ));
    }
}
