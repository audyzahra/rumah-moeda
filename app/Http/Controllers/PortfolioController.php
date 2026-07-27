<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;

class PortfolioController extends Controller
{
    /**
     * Menampilkan daftar portofolio.
     */
    public function index()
    {
        $portfolios = Portfolio::with([
            'category',
            'partner',
            'media' => function ($query) {
                $query->orderBy('display_order');
            }
        ])
        ->latest('activity_date')
        ->paginate(9);

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

        return view('portfolio.detail', compact(
            'portfolio',
            'relatedPortfolios'
        ));
    }
}
