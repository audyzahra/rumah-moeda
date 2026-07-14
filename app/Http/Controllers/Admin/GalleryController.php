<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with(['author', 'media']);

        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');

            });
        }

        // Sorting
        switch ($request->sort) {

            case 'oldest':
                $query->oldest();
                break;

            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        $galleries = $query
            ->paginate(9)
            ->withQueryString();

        return view('admin.galeri.galeri', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galeri.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'activity_date' => 'required|date',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'videos.*' => 'nullable|url',
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'author_id' => Auth::id(),
        ]);

        // Simpan foto
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('galleries', 'public');

                GalleryMedia::create([
                    'gallery_id' => $gallery->id,
                    'type' => 'image',
                    'file_path' => $path,
                    'video_url' => null,
                ]);
            }
        }

        // Simpan video
        if ($request->filled('videos')) {

            foreach ($request->videos as $video) {

                if (!empty($video)) {

                    GalleryMedia::create([
                        'gallery_id' => $gallery->id,
                        'type' => 'video',
                        'file_path' => null,
                        'video_url' => $video,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Data galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('media');

        $galleries = Gallery::with(['author', 'media'])
            ->latest()
            ->paginate(9);

        return view('admin.galeri.galeri', compact(
            'galleries',
            'gallery'
        ));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'activity_date' => 'required|date',
            'description' => 'nullable',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'videos.*' => 'nullable|url',
        ]);

        $gallery->update([
            'title' => $data['title'],
            'activity_date' => $data['activity_date'],
            'description' => $data['description'] ?? null,
        ]);

        // Tambah foto baru
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('galleries', 'public');

                GalleryMedia::create([
                    'gallery_id' => $gallery->id,
                    'type' => 'image',
                    'file_path' => $path,
                ]);
            }
        }

        // Tambah video baru
        if ($request->filled('videos')) {

            foreach ($request->videos as $video) {

                if (!empty($video)) {

                    GalleryMedia::create([
                        'gallery_id' => $gallery->id,
                        'type' => 'video',
                        'video_url' => $video,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->load('media');

        foreach ($gallery->media as $media) {

            if (
                $media->type === 'image' &&
                $media->file_path &&
                Storage::disk('public')->exists($media->file_path)
            ) {
                Storage::disk('public')->delete($media->file_path);
            }
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Data galeri berhasil dihapus.');
    }

    public function destroyMedia(GalleryMedia $media)
    {
        if (
            $media->type === 'image' &&
            $media->file_path &&
            Storage::disk('public')->exists($media->file_path)
        ) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

