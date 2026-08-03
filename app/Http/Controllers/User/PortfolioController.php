<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PortfolioMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;

class PortfolioController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
    /**
     * Menampilkan daftar portfolio milik user
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);

        $query = Portfolio::with([
            'category',
            'partner',
            'media',
            'author'
        ])->where('author_id', Auth::id());

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        switch ($request->sort) {
            case 'oldest':
                $query->oldest('activity_date');
                break;

            case 'title_asc':
                $query->orderBy('title');
                break;

            case 'title_desc':
                $query->orderByDesc('title');
                break;

            default:
                $query->latest('activity_date');
                break;
        }

        $portfolios = $query
            ->paginate($perPage)
            ->withQueryString();

        $categories = PortfolioCategory::orderBy('name')->get();
        $partners = Partner::orderBy('name')->get();

        return view('user.portfolios.index', compact(
            'portfolios',
            'categories',
            'partners'
        ));
    }

    public function create()
    {
        $categories = PortfolioCategory::orderBy('name')->get();
        $partners = Partner::orderBy('name')->get();

        return view('user.portfolios.create', compact(
            'categories',
            'partners'
        ));
    }

    public function store(Request $request)
    {


        $data = $request->validate(
            [

                'category_id' => 'required|exists:portfolio_categories,id',
                'partner_id' => 'nullable|exists:partners,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'activity_date' => 'required|date',
                'author_id' => 'nullable|exists:users,id',
                'location' => 'required|string|max:255',
                'participants' => 'nullable|integer|min:0',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
                'video_url.*' => 'nullable|url',

            ],
            [
                'category_id.required' => 'Kategori wajib dipilih.',
                'title.required' => 'Judul wajib diisi.',
                'description.required' => 'Deskripsi wajib diisi.',
                'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
                'location.required' => 'Lokasi wajib diisi.',

                'latitude.numeric' => 'Latitude harus berupa angka.',
                'latitude.between' => 'Latitude harus berada antara -90 sampai 90.',

                'longitude.numeric' => 'Longitude harus berupa angka.',
                'longitude.between' => 'Longitude harus berada antara -180 sampai 180.',

                'images.required' => 'Minimal upload 1 foto.',
                'images.array' => 'Minimal upload 1 foto.',
                'images.min' => 'Minimal upload 1 foto.',
                'images.*.image' => 'File harus berupa gambar.',
                'images.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
                'images.*.max' => 'Ukuran gambar maksimal 2 MB.',

                'video_url.*.url' => 'URL video YouTube tidak valid.',
            ]
        );

        try {

            $title = $this->security->cleanText($data['title']);

            $location = !empty($data['location'])
                ? $this->security->cleanText($data['location'])
                : null;

            $description = $this->security->cleanHtml($data['description']);
        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $portfolio = Portfolio::create([

            'author_id' => Auth::id(),

            'category_id' => $request->category_id,

            'partner_id' => $request->partner_id,

            'title' => $title,

            'slug' => Str::slug($title),

            'description' => $description,

            'activity_date' => $request->activity_date,

            'location' => $location,

            'participants' => $request->participants ?? 0,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,


        ]);


        // Upload gambar
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $index => $image) {

                $path = $image->store(
                    'portfolio',
                    'public'
                );


                PortfolioMedia::create([
                    'portfolio_id' => $portfolio->id,
                    'type' => 'image',
                    'file_path' => $path,
                    'display_order' => $index
                ]);
            }
        }


        // Simpan video
        // Simpan video

        if ($request->video_url) {

            foreach ($request->video_url as $index => $video) {


                if ($video) {


                    PortfolioMedia::create([

                        'portfolio_id' => $portfolio->id,
                        'type' => 'video',
                        'video_url' => $video,
                        'display_order' => $index

                    ]);
                }
            }
        }

        return redirect()
            ->route('user.portfolios.index')
            ->with([
                'title' => 'Berhasil! 🎉',
                'success' => 'Portofolio berhasil ditambahkan.'
            ]);
    }

    public function show(string $id)
    {

        $portfolio = Portfolio::with([
            'category',
            'partner',
            'media'
        ])
            ->where('author_id', Auth::id())
            ->where('id', $id)
            ->findOrFail($id);



        return response()->json($portfolio);
    }


    public function edit(string $id)
    {


        $portfolio = Portfolio::with('media', 'author')
            ->where('author_id', Auth::id())
            ->where('id', $id)
            ->findOrFail($id);

        $categories = PortfolioCategory::all();


        $partners = Partner::all();



        return view(
            'user.portfolios.edit',
            compact(
                'portfolio',
                'categories',
                'partners'
            )
        );
    }

    public function update(Request $request, string $id)
    {


        $data = $request->validate(
            [
                'category_id' => 'required|exists:portfolio_categories,id',
                'partner_id' => 'nullable|exists:partners,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'activity_date' => 'required|date',
                'location' => 'required|string|max:255',
                'participants' => 'nullable|integer|min:0',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'video_url.*' => 'nullable|url',
                'delete_media.*' => 'nullable|exists:portfolio_media,id',

            ],
            [
                'category_id.required' => 'Kategori wajib dipilih.',
                'title.required' => 'Judul wajib diisi.',
                'description.required' => 'Deskripsi wajib diisi.',
                'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
                'location.required' => 'Lokasi wajib diisi.',

                'latitude.numeric' => 'Latitude harus berupa angka.',
                'latitude.between' => 'Latitude harus berada antara -90 sampai 90.',

                'longitude.numeric' => 'Longitude harus berupa angka.',
                'longitude.between' => 'Longitude harus berada antara -180 sampai 180.',

                'images.required' => 'Minimal upload 1 foto.',
                'images.array' => 'Minimal upload 1 foto.',
                'images.min' => 'Minimal upload 1 foto.',
                'images.*.image' => 'File harus berupa gambar.',
                'images.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
                'images.*.max' => 'Ukuran gambar maksimal 2 MB.',

                'video_url.*.url' => 'URL video YouTube tidak valid.',
            ]
        );
        try {

            $title = $this->security->cleanText($data['title']);

            $location = !empty($data['location'])
                ? $this->security->cleanText($data['location'])
                : null;

            $description = $this->security->cleanHtml($data['description']);
        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $portfolio = Portfolio::where('author_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $currentImages = $portfolio->media()
            ->where('type', 'image')
            ->count();

        $deletedImages = PortfolioMedia::whereIn(
            'id',
            $request->delete_media ?? []
        )
            ->where('type', 'image')
            ->count();

        $newImages = count($request->file('images') ?? []);

        $remainingImages = $currentImages - $deletedImages + $newImages;

        if ($remainingImages < 1) {
            return back()
                ->withInput()
                ->withErrors([
                    'images' => 'Portfolio harus memiliki minimal 1 foto.'
                ]);
        }

        $portfolio->update([

            'category_id' => $request->category_id,

            'partner_id' => $request->partner_id,

            'title' => $title,

            'slug' => Str::slug($title),

            'description' => $description,

            'activity_date' => $request->activity_date,

            'location' => $location,

            'participants' => $request->participants ?? 0,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

        ]);


        // =========================
        // HAPUS MEDIA LAMA
        // =========================

        if ($request->delete_media) {

            $media = PortfolioMedia::whereIn(
                'id',
                $request->delete_media
            )->get();


            foreach ($media as $item) {

                if ($item->type == 'image' && $item->file_path) {

                    Storage::disk('public')
                        ->delete($item->file_path);
                }


                $item->delete();
            }
        }



        // =========================
        // TAMBAH FOTO
        // =========================

        if ($request->hasFile('images')) {


            foreach ($request->file('images') as $index => $image) {


                $path = $image->store(
                    'portfolio',
                    'public'
                );


                PortfolioMedia::create([

                    'portfolio_id' => $portfolio->id,

                    'type' => 'image',

                    'file_path' => $path,

                    'display_order' => $index

                ]);
            }
        }



        // =========================
        // TAMBAH VIDEO
        // =========================

        if ($request->video_url) {


            foreach ($request->video_url as $index => $video) {


                if ($video) {


                    PortfolioMedia::create([

                        'portfolio_id' => $portfolio->id,

                        'type' => 'video',

                        'video_url' => $video,

                        'display_order' => $index

                    ]);
                }
            }
        }



        return redirect()
            ->route('user.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui');
    }

    public function destroy(string $id)
    {

        $portfolio = Portfolio::with('media')
            ->where('author_id', Auth::id())
            ->where('id', $id)
            ->findOrFail($id);


        foreach ($portfolio->media as $media) {

            if ($media->type == 'image' && $media->file_path) {

                Storage::disk('public')
                    ->delete($media->file_path);
            }
        }


        $portfolio->delete();


        return redirect()
            ->route('user.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus');
    }
}
