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
    public function foto()
    {
        $gallery = Gallery::whereHas('media', function ($q) {
                $q->where('type', 'image');
            })
            ->with(['media' => function ($q) {
                $q->where('type', 'image');
            }])
            ->latest()
            ->get();

        $pageTitle = "Galeri Foto";

        return view('galeri', compact('gallery', 'pageTitle'));
    }
   public function video()
    {
        $gallery = Gallery::whereHas('media', function ($q) {
                $q->where('type', 'video');
            })
            ->with(['media' => function ($q) {
                $q->where('type', 'video');
            }])
            ->latest()
            ->get();

        $pageTitle = "Galeri Video";

        return view('galeri', compact('gallery', 'pageTitle'));
    }
}
