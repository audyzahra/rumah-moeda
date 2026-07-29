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
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'activity_date' => 'required|date',

        // Foto wajib minimal 1
        'images' => 'required|array|min:1',
        'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

        // Video opsional
        'videos' => 'nullable|array',
        'videos.*' => 'nullable|url',
    ], [
        'title.required' => 'Judul galeri wajib diisi.',
        'title.max' => 'Judul maksimal 255 karakter.',

        'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
        'activity_date.date' => 'Format tanggal tidak valid.',

        'images.required' => 'Minimal harus menambahkan 1 foto.',
        'images.array' => 'Format foto tidak valid.',
        'images.min' => 'Minimal harus menambahkan 1 foto.',

        'images.*.required' => 'Foto wajib dipilih.',
        'images.*.image' => 'File harus berupa gambar.',
        'images.*.mimes' => 'Format gambar hanya boleh JPG, JPEG, PNG atau WEBP.',
        'images.*.max' => 'Ukuran gambar maksimal 2 MB.',

        'videos.*.url' => 'Link video harus berupa URL yang valid.',
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

        return view('admin.galeri.edit', compact(
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

            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
        ]);

        // Hitung foto yang masih ada di database
        $existingImages = $gallery->media()
            ->where('type', 'image')
            ->count();

        // Hitung foto baru yang diupload
        $newImages = $request->hasFile('images')
            ? count($request->file('images'))
            : 0;

        // Minimal harus ada 1 foto
        if (($existingImages + $newImages) < 1) {

            return back()
                ->withErrors([
                    'images' => 'Minimal galeri harus memiliki 1 foto.'
                ])
                ->withInput();
        }

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
