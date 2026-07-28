<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Partner;
use App\Models\PortfolioMedia;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{


    public function index(Request $request)
{

    $query = Portfolio::with([
        'category',
        'partner',
        'media',
        'author'
    ]);


    // SEARCH
    if($request->search){

        $query->where(function($q) use ($request){

            $q->where('title', 'like', '%' . $request->search . '%')

            ->orWhereHas('category', function($category) use ($request){

                $category->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );

            })

            ->orWhereHas('partner', function($partner) use ($request){

                $partner->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );

            })

            ->orWhereHas('author', function($author) use ($request){

                $author->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );

            });

        });

    }



    // SORTING

    if($request->sort == 'oldest'){

        $query->oldest();

    }elseif($request->sort == 'title_asc'){

        $query->orderBy('title','asc');

    }elseif($request->sort == 'title_desc'){

        $query->orderBy('title','desc');

    }else{

        $query->latest();

    }



    $portfolios = $query->get();


    return view(
        'admin.portfolios.index',
        compact('portfolios')
    );

}





    public function create()
    {


        $categories = PortfolioCategory::all();


        $partners = Partner::all();



        return view(
            'admin.portfolios.create',
            compact(
                'categories',
                'partners'
            )
        );
    }





    public function store(Request $request)
    {


        $request->validate([

    'category_id' => 'required',
    'partner_id' => 'nullable',
    'title' => 'required',
    'description' => 'required',
    'activity_date' => 'required',
    'author_id' => 'nullable|exists:users,id',
    'location' => 'nullable',
    'participants' => 'nullable|integer',

    'images.*' => 'nullable|image|max:2048',
    'video_url.*' => 'nullable|url'

]);




        $portfolio = Portfolio::create([

    'author_id' => Auth::id(),

    'category_id' => $request->category_id,

    'partner_id' => $request->partner_id,

    'title' => $request->title,

    'slug' => Str::slug($request->title),

    'description' => $request->description,

    'activity_date' => $request->activity_date,

    'location' => $request->location,

    'participants' => $request->participants ?? 0,

    'location'  => $request->location,

    'latitude'  => $request->latitude,

    'longitude' => $request->longitude

]);


// Upload gambar
if($request->hasFile('images')){

    foreach($request->file('images') as $index => $image){

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

if($request->video_url){

    foreach($request->video_url as $index => $video){


        if($video){


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
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan');
    }





    public function show(string $id)
    {

        $portfolio = Portfolio::with([
    'category',
    'partner',
    'media'
])
            ->findOrFail($id);



        return response()->json($portfolio);
    }





    public function edit(string $id)
    {


        $portfolio = Portfolio::with('media', 'author')
    ->findOrFail($id);

        $categories = PortfolioCategory::all();


        $partners = Partner::all();



        return view(
            'admin.portfolios.edit',
            compact(
                'portfolio',
                'categories',
                'partners'
            )
        );
    }





    public function update(Request $request, string $id)
    {


        $request->validate([
    'category_id' => 'required',
    'partner_id' => 'nullable',
    'title' => 'required',
    'description' => 'required',
    'activity_date' => 'required',
    'location' => 'nullable',
    'participants' => 'nullable|integer',

    'images.*' => 'nullable|image|max:2048',
    'video_url.*' => 'nullable|url',
    'delete_media.*' => 'nullable|exists:portfolio_media,id'

]);




        $portfolio = Portfolio::findOrFail($id);


        $portfolio->update([

    'category_id' => $request->category_id,

    'partner_id' => $request->partner_id,

    'title' => $request->title,

    'slug' => Str::slug($request->title),

    'description' => $request->description,

    'activity_date' => $request->activity_date,

    'location' => $request->location,

    'participants' => $request->participants ?? 0,

    'location'  => $request->location,

    'latitude'  => $request->latitude,

    'longitude' => $request->longitude

]);


// =========================
// HAPUS MEDIA LAMA
// =========================

if($request->delete_media){

    $media = PortfolioMedia::whereIn(
        'id',
        $request->delete_media
    )->get();


    foreach($media as $item){

        if($item->type == 'image' && $item->file_path){

            Storage::disk('public')
                ->delete($item->file_path);

        }


        $item->delete();

    }

}



// =========================
// TAMBAH FOTO
// =========================

if($request->hasFile('images')){


    foreach($request->file('images') as $index => $image){


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

if($request->video_url){


    foreach($request->video_url as $index => $video){


        if($video){


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
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui');
    }





    public function destroy(string $id)
{

    $portfolio = Portfolio::with('media')
        ->findOrFail($id);


    foreach($portfolio->media as $media){

        if($media->type == 'image' && $media->file_path){

            Storage::disk('public')
                ->delete($media->file_path);

        }

    }


    $portfolio->delete();


    return redirect()
        ->route('admin.portfolios.index')
        ->with('success','Portfolio berhasil dihapus');

}



public function searchLocation(Request $request)
{
    $response = Http::withHeaders([
        'User-Agent' => 'RumahMoeda'
    ])->get(
        'https://nominatim.openstreetmap.org/search',
        [
            'q' => $request->keyword,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 10,
            'countrycodes' => 'id',
            'accept-language' => 'id',
            'dedupe' => 1
        ]
    );


    return response()->json(
        collect($response->json())->map(function($item){

            return [

                'name' => $item['display_name'],

                'lat' => $item['lat'],

                'lon' => $item['lon'],

                'address' => $item['address'] ?? []

            ];

        })
    );
}



public function search(Request $request)
{

    $query = Portfolio::with([
        'category',
        'partner',
        'media',
        'author'
    ]);


    if($request->search){

        $search = $request->search;


        $query->where(function($q) use($search){

            $q->where('title','like',"%$search%")


            ->orWhereHas('category',function($category) use($search){

                $category->where(
                    'name',
                    'like',
                    "%$search%"
                );

            })


            ->orWhereHas('partner',function($partner) use($search){

                $partner->where(
                    'name',
                    'like',
                    "%$search%"
                );

            })


            ->orWhereHas('author',function($author) use($search){

                $author->where(
                    'name',
                    'like',
                    "%$search%"
                );

            });

        });

    }



    if($request->sort == 'oldest'){

        $query->oldest();

    }elseif($request->sort == 'title_asc'){

        $query->orderBy('title','asc');

    }elseif($request->sort == 'title_desc'){

        $query->orderBy('title','desc');

    }else{

        $query->latest();

    }



    $portfolios = $query->get();



    return view(
        'admin.portfolios.partials.table',
        compact('portfolios')
    );

}

}
