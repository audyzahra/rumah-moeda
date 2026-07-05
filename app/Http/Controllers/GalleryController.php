<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::latest('activity_date')->get();

        return view('gallery', compact('gallery'));
    }
}
