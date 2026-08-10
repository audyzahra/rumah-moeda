<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Setting;
use App\Services\SeoService;

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

    public function photos(Request $request, SeoService $seoService)
    {
        $perPage = $request->input('per_page', 6);

        $query = Gallery::with([
            'media' => function ($q) {
                $q->where('type', 'image');
            }
        ])->whereHas('media', function ($q) {
            $q->where('type', 'image');
        });

        // Login
        if (Auth::check()) {
            $query->where('author_id', Auth::id());
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */
        switch ($request->sort) {
            case 'terlama':
                $query->oldest('activity_date');
                break;

            case 'az':
                $query->orderBy('title', 'asc');
                break;

            case 'za':
                $query->orderBy('title', 'desc');
                break;

            default:
                $query->latest('activity_date');
                break;
        }

        $gallery = $query
            ->paginate($perPage)
            ->withQueryString();

        $setting = Setting::first();
        $seo = $seoService->generate($setting);

        return view('gallery.photos', compact('gallery', 'seo'));
    }

    /*
    |--------------------------------------------------------------------------
    | Video Gallery
    |--------------------------------------------------------------------------
    */
    public function videos(Request $request, SeoService $seoService)
    {
        $perPage = $request->input('per_page', 6);

        $query = Gallery::with([
            'media' => function ($q) {
                $q->where('type', 'video');
            }
        ])->whereHas('media', function ($q) {
            $q->where('type', 'video');
        });

        // Login
        if (Auth::check()) {
            $query->where('author_id', Auth::id());
        }
        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */
        switch ($request->sort) {
            case 'terlama':
                $query->oldest('activity_date');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'za':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest('activity_date');
                break;
        }
        $gallery = $query
            ->paginate($perPage)
            ->withQueryString();

        $setting = Setting::first();
        $seo = $seoService->generate($setting);

        return view('gallery.videos', compact('gallery', 'seo'));
    }

    /*
    |--------------------------------------------------------------------------
    | Photo Detail
    |--------------------------------------------------------------------------
    */

    public function photoDetail(Gallery $gallery, SeoService $seoService)
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

        $setting = Setting::first();

        $seo = $seoService->generate(
            $setting,
            $gallery
        );

        return view('gallery.photo-detail', compact('gallery', 'seo'));
    }

    /*
    |--------------------------------------------------------------------------
    | Video Detail
    |--------------------------------------------------------------------------
    */

    public function videoDetail(Gallery $gallery, SeoService $seoService)
    { {
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

            $setting = Setting::first();

            $seo = $seoService->generate(
                $setting,
                $gallery
            );

            return view('gallery.video-detail', compact('gallery', 'seo'));
        }
    }
}
