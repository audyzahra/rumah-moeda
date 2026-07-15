<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar berita milik user
     */
    public function index()
    {
        $news = News::with(['category', 'author'])
            ->where('author_id', Auth::id())
            ->orderByDesc('publish_date')
            ->get();

        $categories = Category::orderBy('name')->get();

        $totalNews = $news->count();
        $totalPublished = $news->count();
        $totalDraft = 0;
        $totalCategory = $categories->count();

        return view('user.news.index', compact(
            'news',
            'categories',
            'totalNews',
            'totalPublished',
            'totalDraft',
            'totalCategory'
        ));
    }

    /**
     * Halaman tambah berita
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('user.news.create', compact('categories'));
    }

    /**
     * Simpan berita
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required',
            'category_id'   => 'required|exists:categories,id',
            'publish_date'  => 'required|date',
            'thumbnail'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('news', 'public');
        }

        News::create([
            'title'         => $request->title,
            'thumbnail'     => $thumbnail,
            'content'       => $request->content,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($request->title),
            'publish_date'  => $request->publish_date,
            'author_id'     => Auth::id(),
        ]);

        return redirect()
            ->route('user.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Detail berita
     */
    public function show($id)
    {
        $news = News::with(['category', 'author'])
            ->where('author_id', Auth::id())
            ->findOrFail($id);

        return view('user.news.show', compact('news'));
    }

    /**
     * Halaman edit berita
     */
    public function edit($id)
    {
        $news = News::where('author_id', Auth::id())
            ->findOrFail($id);

        $categories = Category::orderBy('name')->get();

        return view('user.news.edit', compact(
            'news',
            'categories'
        ));
    }

    /**
     * Update berita
     */
    public function update(Request $request, $id)
    {
        $news = News::where('author_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required',
            'category_id'   => 'required|exists:categories,id',
            'publish_date'  => 'required|date',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $thumbnail = $news->thumbnail;

        if ($request->hasFile('thumbnail')) {

            if (
                $thumbnail &&
                Storage::disk('public')->exists($thumbnail)
            ) {
                Storage::disk('public')->delete($thumbnail);
            }

            $thumbnail = $request->file('thumbnail')
                ->store('news', 'public');
        }

        $news->update([
            'title'         => $request->title,
            'thumbnail'     => $thumbnail,
            'content'       => $request->content,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($request->title),
            'publish_date'  => $request->publish_date,
        ]);

        return redirect()
            ->route('user.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Hapus berita
     */
    public function destroy($id)
    {
        $news = News::where('author_id', Auth::id())
            ->findOrFail($id);

        if (
            $news->thumbnail &&
            Storage::disk('public')->exists($news->thumbnail)
        ) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()
            ->route('user.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
