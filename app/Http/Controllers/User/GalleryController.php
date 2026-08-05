<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;
use Illuminate\Support\Facades\Crypt;

class GalleryController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
    /**
     * List gallery user
     */
    public function index(Request $request)
    {
        $query = Gallery::with([
            'media',
            'author'
        ])->where('author_id', Auth::id());

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");

            });

        }

        switch ($request->sort) {

            case 'oldest':
                $query->oldest();
                break;

            case 'title_asc':
                $query->orderBy('title');
                break;

            case 'title_desc':
                $query->orderByDesc('title');
                break;

            default:
                $query->latest();

        }

        $perPage = $request->get('per_page', 5);

        $galleries = $query
            ->paginate($perPage)
            ->withQueryString();

        return view('user.gallery.index', compact('galleries'));
    }

    /**
     * halaman tambah
     */
    public function create()
    {
        return view('user.gallery.create');
    }

    /**
     * simpan gallery
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'activity_date' => 'required|date',

            'photos' => 'required|array|min:1',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
        ], [
            'title.required' => 'Judul galeri wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',

            'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
            'activity_date.date' => 'Format tanggal tidak valid.',

            'photos.required' => 'Minimal harus menambahkan 1 foto.',
            'photos.array' => 'Format foto tidak valid.',
            'photos.min' => 'Minimal harus menambahkan 1 foto.',

            'photos.*.required' => 'Foto wajib dipilih.',
            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar hanya boleh JPG, JPEG, PNG atau WEBP.',
            'photos.*.max' => 'Ukuran gambar maksimal 2 MB.',

            'videos.*.url' => 'Link video harus berupa URL yang valid.',
        ]);
                try {

                    $title = $this->security->cleanText($request->title);

                    $description = $request->filled('description')
                        ? $this->security->cleanHtml($request->description)
                        : null;

                } catch (DangerousInputException $e) {

                    return back()
                        ->withInput()
                        ->with('error', $e->getMessage());

                }

                if (Gallery::where('title', $title)->exists()) {

                    return back()
                        ->withInput()
                        ->with('error', 'Judul dokumentasi sudah digunakan. Silakan gunakan judul lain.');

                }
                $gallery = Gallery::create([
                    'title' => $title,
                    'description' => $description,
                    'activity_date' => $request->activity_date,
                    'author_id' => Auth::id(),
                ]);
        /*
        |--------------------------------------------------------------------------
        | Upload Foto
        |--------------------------------------------------------------------------
        */

        if($request->hasFile('photos')){

            foreach($request->file('photos') as $photo){

                $path = $photo->store('galleries','public');

                GalleryMedia::create([

                    'gallery_id'=>$gallery->id,

                    'type'=>'image',

                    'file_path'=>$path

                ]);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Video Youtube
        |--------------------------------------------------------------------------
        */

        if($request->videos){

            foreach($request->videos as $video){

                if($video){

                    GalleryMedia::create([

                        'gallery_id'=>$gallery->id,

                        'type'=>'video',

                        'video_url'=>$video

                    ]);

                }

            }

        }

        return redirect()
        ->route('user.gallery.index')
        ->with([
            'title' => 'Berhasil! 🎉',
            'success' => 'Galeri berhasil ditambahkan.'
        ]);
    }

    /**
     * Detail
     */
    public function show(string $id)
    {
        $id = Crypt::decryptString($id);

        $gallery = Gallery::with([
            'media',
            'author'
        ])->findOrFail($id);

        abort_if($gallery->author_id != Auth::id(), 403);

        return response()->json($gallery);
    }

    /**
     * Edit
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);

        $gallery = Gallery::with([
            'media',
            'author'
        ])->findOrFail($id);

        abort_if($gallery->author_id != Auth::id(), 403);

        return view('user.gallery.edit', compact('gallery'));
    }

    /**
     * Update
     */
    public function update(Request $request, Gallery $gallery)
    {
        $id = Crypt::decryptString($id);
        $gallery = Gallery::findOrFail($id);
        abort_if($gallery->author_id!=Auth::id(),403);

        $data = $request->validate([

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'activity_date' => 'required|date',

            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'videos' => 'nullable|array',

            'videos.*' => 'nullable|url'

        ], [

            'title.required' => 'Judul galeri wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',

            'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
            'activity_date.date' => 'Format tanggal tidak valid.',

            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar hanya boleh JPG, JPEG, PNG atau WEBP.',
            'photos.*.max' => 'Ukuran gambar maksimal 2 MB.',

            'videos.*.url' => 'Link video harus berupa URL yang valid.',

        ]);

        try {

            $title = $this->security->cleanText($data['title']);

            $description = !empty($data['description'])
                ? $this->security->cleanHtml($data['description'])
                : null;

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }

        $existingImages = $gallery->media()
    ->where('type', 'image')
    ->count();

$deletedImages = 0;

if ($request->filled('deleted_media')) {

    $deletedImages = GalleryMedia::whereIn(
        'id',
        $request->deleted_media
    )
    ->where('type', 'image')
    ->count();

}

$newImages = $request->hasFile('photos')
    ? count($request->file('photos'))
    : 0;

$totalImages = $existingImages - $deletedImages + $newImages;

if ($totalImages < 1) {

    return back()
        ->withErrors([
            'photos' => 'Minimal galeri harus memiliki 1 foto.'
        ])
        ->withInput();

}

        $gallery->update([

            'title' => $title,

            'description' => $description,

            'activity_date' => $data['activity_date'],

        ]);

        /*
|--------------------------------------------------------------------------
| Hapus Media Lama
|--------------------------------------------------------------------------
*/

if ($request->filled('deleted_media')) {

    foreach ($request->deleted_media as $id) {

        $media = GalleryMedia::find($id);

        if (!$media) {
            continue;
        }

        if (
            $media->type == 'image' &&
            $media->file_path &&
            Storage::disk('public')->exists($media->file_path)
        ) {

            Storage::disk('public')->delete($media->file_path);

        }

        $media->delete();

    }

}
        /*
        |--------------------------------------------------------------------------
        | Tambah Foto Baru
        |--------------------------------------------------------------------------
        */

        if($request->hasFile('photos')){

            foreach($request->file('photos') as $photo){

                $path = $photo->store('galleries','public');

                GalleryMedia::create([

                    'gallery_id'=>$gallery->id,

                    'type'=>'image',

                    'file_path'=>$path

                ]);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Tambah Video Baru
        |--------------------------------------------------------------------------
        */

        if($request->videos){

            foreach($request->videos as $video){

                if($video){

                    GalleryMedia::create([

                        'gallery_id'=>$gallery->id,

                        'type'=>'video',

                        'video_url'=>$video

                    ]);

                }

            }

        }

        return redirect()
            ->route('user.gallery.index')
            ->with([
                'title' => 'Berhasil! 🎉',
                'success' => 'Galeri berhasil diperbarui.'
            ]);
    }

    /**
     * Hapus
     */
    public function destroy(string $id)
    {
        $id = Crypt::decryptString($id);

        $gallery = Gallery::with('media')->findOrFail($id);

        abort_if($gallery->author_id != Auth::id(), 403);

        foreach ($gallery->media as $media) {

            if (
                $media->type == 'image' &&
                $media->file_path &&
                Storage::disk('public')->exists($media->file_path)
            ) {
                Storage::disk('public')->delete($media->file_path);
            }

            $media->delete();
        }

        $gallery->delete();

        return redirect()
            ->route('user.gallery.index')
            ->with([
                'title' => 'Berhasil! 🎉',
                'success' => 'Galeri berhasil dihapus.'
            ]);
    }
}
