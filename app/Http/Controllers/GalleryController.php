<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            // Jika sudah login (admin atau user),
            // hanya tampilkan galeri miliknya sendiri
            $gallery = Gallery::where('author_id', Auth::id())
                ->latest('activity_date')
                ->get();

        } else {

            // Guest melihat semua galeri
            $gallery = Gallery::latest('activity_date')
                ->get();

        }

        return view('gallery', compact('gallery'));
    }
}
