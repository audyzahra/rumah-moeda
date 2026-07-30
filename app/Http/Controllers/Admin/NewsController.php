<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Services\Security\DangerousInputException;
use App\Services\SecurityInputService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }

    /**
     * Menampilkan halaman berita
     */
    public function index()
    {
        $news = News::with(['category', 'author'])
            ->orderByDesc('publish_date')
            ->paginate(5);

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

        try {

            $title = $this->security->cleanText($request->title);
            $content = $this->security->cleanHtml($request->content);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('news', 'public');
        }

        News::create([
            'title'         => $title,
            'thumbnail'     => $thumbnail,
            'content'       => $content,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($title),
            'publish_date'  => $request->publish_date,
            'author_id'     => Auth::id(),
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with([
                'title'   => 'Berhasil! 🎉',
                'success' => 'Berita berhasil ditambahkan.'
            ]);
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

        try {

            $title = $this->security->cleanText($request->title);
            $content = $this->security->cleanHtml($request->content);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $thumbnail = $beritum->thumbnail;

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

        $beritum->update([
            'title'         => $title,
            'thumbnail'     => $thumbnail,
            'content'       => $content,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($title),
            'publish_date'  => $request->publish_date,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with([
                'title'   => 'Berhasil! 🎉',
                'success' => 'Berita berhasil diperbarui.'
            ]);
    }

    /**
     * Hapus berita
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if (
            $news->thumbnail &&
            Storage::disk('public')->exists($news->thumbnail)
        ) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with([
                'title'   => 'Berhasil Dihapus 🗑️',
                'success' => 'Berita berhasil dihapus.'
            ]);
    }
}
