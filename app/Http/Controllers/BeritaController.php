<?php

namespace App\Http\Controllers;

use App\Models\News;

class BeritaController extends Controller
{
    public function index()
    {
        $news = News::with(['category','author'])
            ->latest('publish_date')
            ->get();

        return view('berita', compact('news'));
    }

    public function show($slug)
{
    $news = News::with(['category','author'])
        ->where('slug', $slug)
        ->firstOrFail();

    $otherNews = News::where('news_id','!=',$news->news_id)
        ->latest('publish_date')
        ->take(2)
        ->get();

    return view('detail-berita', compact(
        'news',
        'otherNews'
    ));
}
}
