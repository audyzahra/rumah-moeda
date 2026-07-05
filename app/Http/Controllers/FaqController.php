<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('display_order')->get();

        return view('pertanyaan', compact('faqs'));
    }
}
