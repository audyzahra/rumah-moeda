<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Gallery Landing
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Photo Gallery
    |--------------------------------------------------------------------------
    */

    public function photos()
    {
        $query = Gallery::with([
            'media' => function ($q) {
                $q->where('type', 'image');
            }
        ])->whereHas('media', function ($q) {
            $q->where('type', 'image');
        });

        // Jika login (Admin/User), hanya tampilkan galeri miliknya
        if (Auth::check()) {
            $query->where('author_id', Auth::id());
        }

        $gallery = $query
        ->orderByDesc('activity_date')
        ->get();

        return view('gallery.photos', compact('gallery'));
    }

    /*
    |--------------------------------------------------------------------------
    | Video Gallery
    |--------------------------------------------------------------------------
    */

    public function videos()
    {
        $query = Gallery::with([
            'media' => function ($q) {
                $q->where('type', 'video');
            }
        ])->whereHas('media', function ($q) {
            $q->where('type', 'video');
        });

        if (Auth::check()) {
            $query->where('author_id', Auth::id());
        }

        $gallery = $query
        ->orderByDesc('activity_date')
        ->get();

        return view('gallery.videos', compact('gallery'));
    }

    /*
    |--------------------------------------------------------------------------
    | Photo Detail
    |--------------------------------------------------------------------------
    */

    public function photoDetail(Gallery $gallery)
    {
        // Admin/User hanya boleh membuka galeri miliknya
        if (Auth::check() && $gallery->author_id != Auth::id()) {
            abort(403);
        }

        $gallery->load([
            'media' => function ($q) {
                $q->where('type', 'image');
            }
        ]);
        if ($gallery->media->isEmpty()) {
            abort(404);
        }

        return view('gallery.photo-detail', compact('gallery'));
    }

    /*
    |--------------------------------------------------------------------------
    | Video Detail
    |--------------------------------------------------------------------------
    */

    public function videoDetail(Gallery $gallery)
    {
        if (Auth::check() && $gallery->author_id != Auth::id()) {
            abort(403);
        }

        $gallery->load([
            'media' => function ($q) {
                $q->where('type', 'video');
            }
        ]);
        if ($gallery->media->isEmpty()) {
            abort(404);
        }

        return view('gallery.video-detail', compact('gallery'));
    }
}
