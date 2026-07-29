<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    /**
     * Menampilkan daftar portofolio.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 6);

        // Guest -> semua portofolio
        if (!Auth::check()) {

            $portfolios = Portfolio::with([
                    'category',
                    'partner',
                    'media' => function ($query) {
                        $query->orderBy('display_order');
                    }
                ])
                ->latest('activity_date')
                ->paginate($perPage)
                ->withQueryString();

        }
        // Login (Admin/User) -> hanya portofolio miliknya
        else {

            $portfolios = Portfolio::with([
                    'category',
                    'partner',
                    'media' => function ($query) {
                        $query->orderBy('display_order');
                    }
                ])
                ->where('author_id', Auth::id())
                ->latest('activity_date')
                ->paginate($perPage)
                ->withQueryString();

        }
         $categories = PortfolioCategory::orderBy('name')->get();

        $totalPortfolio = Portfolio::count();

        $totalPartner = Partner::count();

        $totalCategory = PortfolioCategory::count();

        $totalParticipants = Portfolio::sum('participants');

        return view('portfolio.index', compact(
            'portfolios',
            'categories',
            'totalPortfolio',
            'totalPartner',
            'totalCategory',
            'totalParticipants'
        ));
    }   

    /**
     * Menampilkan detail portofolio.
     */
    public function show(Portfolio $portfolio)
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

        return view('portfolio.show', compact(
            'portfolio',
            'relatedPortfolios'
        ));
    }
}
