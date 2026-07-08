<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
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

        $galleries = $query->paginate(9)->withQueryString();

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
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'activity_date' => 'required|date',
        ]);

        $photo = $request->file('photo')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $photo,
            'activity_date' => $request->activity_date,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Data galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        $galleries = Gallery::latest()->paginate(10);

        return view('admin.galeri.galeri', compact(
            'galleries',
            'gallery'
        ));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => 'required',
            'activity_date' => 'required|date',
            'description' => 'nullable',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {

            if ($gallery->photo &&
                Storage::disk('public')->exists($gallery->photo)) {

                Storage::disk('public')->delete($gallery->photo);
            }

            $data['photo'] = $request
                ->file('photo')
                ->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->photo && Storage::disk('public')->exists($gallery->photo)) {
            Storage::disk('public')->delete($gallery->photo);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Data galeri berhasil dihapus.');
    }
}