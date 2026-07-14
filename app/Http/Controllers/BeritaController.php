<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Daftar Berita
     */
    public function index()
    {
        // Guest -> semua berita
        if (!Auth::check()) {

            $news = News::with(['category', 'author'])
                ->latest('publish_date')
                ->get();

        }
        // Login (Admin/User) -> hanya berita miliknya
        else {

            $news = News::with(['category', 'author'])
                ->where('author_id', Auth::id())
                ->latest('publish_date')
                ->get();

        }

        $categories = Category::orderBy('name')->get();

        return view('berita', compact(
            'news',
            'categories'
        ));
    }

    /**
     * Detail Berita
     */
    public function show($slug)
    {
        // Guest
        if (!Auth::check()) {

            $news = News::with(['category', 'author'])
                ->where('slug', $slug)
                ->firstOrFail();

            $otherNews = News::with(['category', 'author'])
                ->where('id', '!=', $news->id)
                ->latest('publish_date')
                ->take(2)
                ->get();

        }
        // Login (Admin/User)
        else {

            $news = News::with(['category', 'author'])
                ->where('slug', $slug)
                ->where('author_id', Auth::id())
                ->firstOrFail();

            $otherNews = News::with(['category', 'author'])
                ->where('author_id', Auth::id())
                ->where('id', '!=', $news->id)
                ->latest('publish_date')
                ->take(2)
                ->get();

        }

        return view('detail-berita', compact(
            'news',
            'otherNews'
        ));
    }

    /**
     * Simpan Berita
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'content'       => 'required',
            'thumbnail'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'publish_date'  => 'required|date',
        ]);

        $file = $request->file('thumbnail');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads/news'), $filename);

        News::create([
            'title'         => $request->title,
            'thumbnail'     => 'uploads/news/' . $filename,
            'content'       => $request->content,
            'category_id'   => 1,
            'slug'          => Str::slug($request->title),
            'publish_date'  => $request->publish_date,
            'author_id'     => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Berita berhasil ditambahkan.'
        );
    }
}
