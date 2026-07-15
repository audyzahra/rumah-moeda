<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Gallery;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalNews = News::where('author_id', $userId)->count();

        $totalGallery = Gallery::where('author_id', $userId)->count();

        $totalMessage = ContactMessage::where('user_id', $userId)->count();

        $totalContent =
            $totalNews +
            $totalGallery +
            $totalMessage;

        /*
        |--------------------------------------------------------------------------
        | Aktivitas Terbaru
        |--------------------------------------------------------------------------
        */

        $latestNews = News::where('author_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $latestGallery = Gallery::where('author_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $latestMessages = ContactMessage::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
        $activities = collect();

            foreach ($latestNews as $news) {
                $activities->push([
                    'type'  => 'news',
                    'title' => $news->title,
                    'date'  => $news->created_at,
                ]);
            }

            foreach ($latestGallery as $gallery) {
                $activities->push([
                    'type'  => 'gallery',
                    'title' => $gallery->title,
                    'date'  => $gallery->created_at,
                ]);
            }

            foreach ($latestMessages as $message) {
                $activities->push([
                    'type'  => 'message',
                    'title' => \Illuminate\Support\Str::limit($message->message, 60),
                    'date'  => $message->created_at,
                ]);
            }

            $activities = $activities
                ->sortByDesc('date')
                ->take(3);

        /*
        |--------------------------------------------------------------------------
        | Berita Terpopuler
        |--------------------------------------------------------------------------
        | Sementara masih mengambil berita terbaru.
        | Nanti tinggal diganti ->orderByDesc('views')
        |--------------------------------------------------------------------------
        */

        $popularNews = News::where('author_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard.index', compact(
            'totalNews',
            'totalGallery',
            'totalMessage',
            'totalContent',
            'latestNews',
            'latestGallery',
            'latestMessages',
            'popularNews',
            'activities'
        ));
    }
}
