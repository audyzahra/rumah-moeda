<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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

            $file = $request->file('thumbnail');

            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/news'), $filename);

            $thumbnail = 'uploads/news/' . $filename;
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
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Update berita
     */
    public function update(Request $request, $id)
    {
        $beritum = News::findOrFail($id);

        $request->validate([
            'title'         => 'required|max:255',
            'content'       => 'required',
            'category_id'   => 'required|exists:categories,id',
            'publish_date'  => 'required|date',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $thumbnail = $beritum->thumbnail;

        if ($request->hasFile('thumbnail')) {

            // Hapus gambar lama
            if ($thumbnail && File::exists(public_path($thumbnail))) {
                File::delete(public_path($thumbnail));
            }

            // Upload gambar baru
            $file = $request->file('thumbnail');

            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/news'), $filename);

            $thumbnail = 'uploads/news/' . $filename;
        }

        $beritum->update([
            'title'         => $request->title,
            'thumbnail'     => $thumbnail,
            'content'       => $request->content,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($request->title) . '-' . time(),
            'publish_date'  => $request->publish_date,
        ]);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Hapus berita
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->thumbnail && File::exists(public_path($news->thumbnail))) {
            File::delete(public_path($news->thumbnail));
        }

        $news->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
