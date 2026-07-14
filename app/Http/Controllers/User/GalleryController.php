<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Menampilkan galeri milik user
     */
    public function index(Request $request)
    {
        $query = Gallery::where('author_id', Auth::id());

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

        return view('user.gallery.index', compact('galleries'));
    }

    /**
     * Halaman tambah
     */
    public function create()
    {
        return view('user.gallery.index');
    }

    /**
     * Simpan galeri
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|max:255',
            'description'    => 'nullable',
            'photo'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'activity_date'  => 'required|date',
        ]);

        $photo = $request->file('photo')
            ->store('galleries', 'public');

        Gallery::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'photo'         => $photo,
            'activity_date' => $request->activity_date,
            'author_id'     => Auth::id(),
        ]);

        return redirect()
            ->route('user.gallery.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Edit galeri milik user
     */
    public function edit(Gallery $gallery)
    {
        abort_if($gallery->author_id != Auth::id(), 403);

        $galleries = Gallery::where('author_id', Auth::id())
            ->latest()
            ->paginate(9);

        return view('user.gallery.index', compact(
            'galleries',
            'gallery'
        ));
    }

    /**
     * Update galeri milik user
     */
    public function update(Request $request, Gallery $gallery)
    {
        abort_if($gallery->author_id != Auth::id(), 403);

        $data = $request->validate([
            'title'         => 'required|max:255',
            'activity_date' => 'required|date',
            'description'   => 'nullable',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {

            if (
                $gallery->photo &&
                Storage::disk('public')->exists($gallery->photo)
            ) {
                Storage::disk('public')->delete($gallery->photo);
            }

            $data['photo'] = $request->file('photo')
                ->store('galleries', 'public');
        }

        $gallery->update($data);

        return redirect()
            ->route('user.gallery.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Hapus galeri milik user
     */
    public function destroy(Gallery $gallery)
    {
        abort_if($gallery->author_id != Auth::id(), 403);

        if (
            $gallery->photo &&
            Storage::disk('public')->exists($gallery->photo)
        ) {
            Storage::disk('public')->delete($gallery->photo);
        }

        $gallery->delete();

        return redirect()
            ->route('user.gallery.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
