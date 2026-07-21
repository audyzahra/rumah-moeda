<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Menampilkan halaman berita
     */
    public function index()
    {
        $news = News::with(['category', 'author'])
            ->orderByDesc('publish_date')
            ->get();

        $categories = Category::orderBy('name')->get();

        $totalNews = $news->count();
        $totalPublished = $news->count();
        $totalDraft = 0;
        $totalCategory = $categories->count();

        return view('admin.berita.berita', compact(
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

        return view('admin.berita.tambah', compact('categories'));
    }

    /**
     * Halaman edit berita
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);

        $categories = Category::orderBy('name')->get();

        return view('admin.berita.edit', compact(
            'news',
            'categories'
        ));
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
        ->route('admin.news.index')
        ->with('success', 'Data berita berhasil ditambahkan.');
    }

    /**
     * Update berita
     */
    public function update(Request $request, $id)
    {
        $beritum = News::findOrFail($id);

        $request->validate([
            'title'         => 'required|string|max:255',
            'content'       => 'required',
            'category_id'   => 'required|exists:categories,id',
            'publish_date'  => 'required|date',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $thumbnail = $beritum->thumbnail;

        if ($request->hasFile('thumbnail')) {

            // Hapus thumbnail lama
            if (
                $thumbnail &&
                Storage::disk('public')->exists($thumbnail)
            ) {
                Storage::disk('public')->delete($thumbnail);
            }

            // Upload thumbnail baru
            $thumbnail = $request->file('thumbnail')
                ->store('news', 'public');
        }

        $beritum->update([
            'title'         => $request->title,
            'thumbnail'     => $thumbnail,
            'content'       => $request->content,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($request->title),
            'publish_date'  => $request->publish_date,
        ]);

        return redirect()
        ->route('admin.news.index')
        ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Hapus berita
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Hapus thumbnail dari storage
        if (
            $news->thumbnail &&
            Storage::disk('public')->exists($news->thumbnail)
        ) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
