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

        $organizations = OrganizationStructure::orderBy('display_order')->get();

        return view('tentang', compact(
            'settings',
            'vision',
            'organizations'
        ));
    }
}
