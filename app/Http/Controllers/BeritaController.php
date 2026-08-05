<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\NewsView;

class BeritaController extends Controller
{
    /**
     * Daftar Berita
     */
    public function index(Request $request)
{
    $perPage = $request->get('per_page', 5);

    if (!Auth::check()) {

        $query = News::with(['category', 'author']);

    } else {

        $query = News::with(['category', 'author'])
            ->where('author_id', Auth::id());

    }

    // SEARCH
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('content', 'like', '%' . $request->search . '%');

        });

    }

    // SORT
    switch ($request->sort) {

        case 'terlama':
            $query->orderBy('publish_date');
            break;

        case 'az':
            $query->orderBy('title');
            break;

        case 'za':
            $query->orderByDesc('title');
            break;

        default:
            $query->latest('publish_date');
            break;
    }

    $news = $query
        ->paginate($perPage)
        ->withQueryString();

    $categories = Category::orderBy('name')->get();

    return view('berita', compact(
        'news',
        'categories'
    ));
}

    /**
     * Detail Berita
     */
    public function show(Request $request, $slug)
{
    // Guest
    if (!Auth::check()) {

        $news = News::with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Tambah views hanya sekali selama session
        $exists = NewsView::where('news_id', $news->id)
            ->where('ip_address', $request->ip())
            ->exists();

        if (!$exists) {

            NewsView::create([
                'news_id' => $news->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $news->increment('views');
        }

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

        // Tambah views hanya sekali selama session
        $exists = NewsView::where('news_id', $news->id)
            ->where('ip_address', $request->ip())
            ->exists();

        if (!$exists) {

            NewsView::create([
                'news_id' => $news->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $news->increment('views');
        }

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
