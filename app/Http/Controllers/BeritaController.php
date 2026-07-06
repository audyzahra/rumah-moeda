<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\News;
use App\Models\Category;

class BeritaController extends Controller
{
    public function index()
    {
        $news = News::with(['category', 'author'])
            ->latest('publish_date')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('berita', compact(
            'news',
            'categories'
        ));
    }

    public function show($slug)
    {
        $news = News::with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        $otherNews = News::where('id', '!=', $news->id)
            ->latest('publish_date')
            ->take(2)
            ->get();

        return view('detail-berita', compact(
            'news',
            'otherNews'
        ));
    }
    public function store(Request $request)
{

    $request->validate([

        'title'=>'required|max:255',

        'content'=>'required',

        'thumbnail'=>'required|image|mimes:jpg,jpeg,png|max:2048',

        'publish_date'=>'required|date',

    ]);

    $file = $request->file('thumbnail');

    $filename = time().'_'.$file->getClientOriginalName();

    $file->move(public_path('uploads/news'),$filename);

    News::create([

        'title'=>$request->title,

        'thumbnail'=>'uploads/news/'.$filename,

        'content'=>$request->content,

        'category_id'=>1,

        'slug'=>Str::slug($request->title),

        'publish_date'=>$request->publish_date,

        'author_id'=>Auth::id(),

    ]);

    return back()->with('success','Berita berhasil ditambahkan.');
}
}
