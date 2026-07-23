<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
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

        $galleries = $query
            ->paginate(9)
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

            'title'=>'required|max:255',

            'description'=>'nullable',

            'activity_date'=>'required|date',

            'photos.*'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'videos.*'=>'nullable|url'

        ]);

        $gallery = Gallery::create([

            'title'=>$request->title,

            'description'=>$request->description,

            'activity_date'=>$request->activity_date,

            'author_id'=>Auth::id()

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
    public function show(Gallery $gallery)
    {
        abort_if($gallery->author_id!=Auth::id(),403);

        $gallery->load([
            'media',
            'author'
        ]);

        return response()->json($gallery);
    }

    /**
     * Edit
     */
    public function edit(Gallery $gallery)
    {
        abort_if($gallery->author_id!=Auth::id(),403);

        $gallery->load([
            'media',
            'author'
        ]);

        return view('user.gallery.edit',compact('gallery'));
    }

    /**
     * Update
     */
    public function update(Request $request, Gallery $gallery)
    {
        abort_if($gallery->author_id!=Auth::id(),403);

        $request->validate([

            'title'=>'required|max:255',

            'description'=>'nullable',

            'activity_date'=>'required|date',

            'photos.*'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'videos.*'=>'nullable|url'

        ]);

        $gallery->update([

            'title'=>$request->title,

            'description'=>$request->description,

            'activity_date'=>$request->activity_date

        ]);

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
    public function destroy(Gallery $gallery)
    {
        abort_if($gallery->author_id!=Auth::id(),403);

        foreach($gallery->media as $media){

            if($media->type=='image'){

                if(Storage::disk('public')->exists($media->file_path)){

                    Storage::disk('public')->delete($media->file_path);

                }

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
