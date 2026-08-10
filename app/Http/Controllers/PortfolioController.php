<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\SeoService;
use App\Models\Setting;

class PortfolioController extends Controller
{
    /**
     * Menampilkan daftar portofolio.
     */
    public function index(Request $request, SeoService $seoService)
    {
        $perPage = $request->input('per_page', 6);

        // Guest -> semua portofolio
        $query = Portfolio::with([
            'category',
            'partner',
            'media' => function ($query) {
                $query->orderBy('display_order');
            }
        ]);

        // Jika login, hanya tampilkan portofolio miliknya
        if (Auth::check()) {

            $query->where('author_id', Auth::id());

        }

        // ==========================
        // SEARCH
        // ==========================
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhereHas('partner', function ($partner) use ($search) {

                    $partner->where('name', 'like', "%{$search}%");

                });

            });

        }
        // ==========================
        // CATEGORY
        // ==========================
        if ($request->filled('category')) {

            $query->whereHas('category', function ($q) use ($request) {

                $q->where('name', $request->category);

            });

        }
        // ==========================
        // SORT
        // ==========================
        switch ($request->sort) {

            case 'oldest':

                $query->oldest('activity_date');

                break;

            default:

                $query->latest('activity_date');

                break;

        }
        // ==========================
        // PAGINATION
        // ==========================
        $portfolios = $query
            ->paginate($perPage)
            ->withQueryString();
        $categories = PortfolioCategory::orderBy('name')->get();

        $totalPortfolio = Portfolio::count();

        $totalPartner = Partner::count();

        $totalCategory = PortfolioCategory::count();

        $totalParticipants = Portfolio::sum('participants');

        // SEO

        $setting = Setting::first();

$seo = $seoService->generate($setting);

        return view('portfolio.index', compact(
            'portfolios',
            'categories',
            'totalPortfolio',
            'totalPartner',
            'totalCategory',
            'totalParticipants',
            'seo'
        ));
    }

    /**
     * Menampilkan detail portofolio.
     */
    public function show(Portfolio $portfolio, SeoService $seoService)
    {
        $portfolio->load([
            'partner',
            'category',
            'media',
        ]);

        $relatedPortfolios = Portfolio::with([
                'partner',
                'category',
                'media',
            ])
            ->where('id', '!=', $portfolio->id)
            ->latest('activity_date')
            ->take(3)
            ->get();

            $setting = Setting::first();

$seo = $seoService->generate($setting, $portfolio);

        return view('portfolio.show', compact(
            'portfolio',
            'relatedPortfolios',
            'seo'
        ));
    }
}
