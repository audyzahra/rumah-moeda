<?php

namespace App\Http\Controllers;

use App\Models\Faq;

use App\Models\Setting;
use App\Services\SeoService;

class FaqController extends Controller
{
    public function index(SeoService $seoService)
    {
        $faqs = Faq::orderBy('display_order')->get();

        $setting = Setting::first();
        $seo = $seoService->generate($setting);

        return view('pertanyaan', compact('faqs', 'seo'));
    }
}
