<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Partner;


class PortfolioController extends Controller
{


    public function index()
    {

        $portfolios = Portfolio::with([
            'category',
            'partner'
        ])
            ->latest()
            ->get();


        return view('admin.portfolios.index', compact('portfolios'));
    }





    public function create()
    {


        $categories = PortfolioCategory::all();


        $partners = Partner::all();



        return view(
            'admin.portfolios.create',
            compact(
                'categories',
                'partners'
            )
        );
    }





    public function store(Request $request)
    {


        $request->validate([

            'category_id' => 'required',
            'partner_id' => 'nullable',
            'title' => 'required',
            'description' => 'required',
            'activity_date' => 'required',
            'location' => 'nullable',
            'participants' => 'nullable|integer'

        ]);




        Portfolio::create([

            'category_id' => $request->category_id,

            'partner_id' => $request->partner_id,

            'title' => $request->title,

            'description' => $request->description,

            'activity_date' => $request->activity_date,

            'location' => $request->location,

            'participants' => $request->participants ?? 0

        ]);




        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan');
    }





    public function show(string $id)
    {

        $portfolio = Portfolio::with([
            'category',
            'partner'
        ])
            ->findOrFail($id);



        return response()->json($portfolio);
    }





    public function edit(string $id)
    {


        $portfolio = Portfolio::findOrFail($id);



        $categories = PortfolioCategory::all();


        $partners = Partner::all();



        return view(
            'admin.portfolios.edit',
            compact(
                'portfolio',
                'categories',
                'partners'
            )
        );
    }





    public function update(Request $request, string $id)
    {


        $request->validate([

            'category_id' => 'required',
            'partner_id' => 'nullable',
            'title' => 'required',
            'description' => 'required',
            'activity_date' => 'required',
            'location' => 'nullable',
            'participants' => 'nullable|integer'

        ]);




        $portfolio = Portfolio::findOrFail($id);



        $portfolio->update([

            'category_id' => $request->category_id,

            'partner_id' => $request->partner_id,

            'title' => $request->title,

            'description' => $request->description,

            'activity_date' => $request->activity_date,

            'location' => $request->location,

            'participants' => $request->participants ?? 0

        ]);




        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui');
    }





    public function destroy(string $id)
    {


        $portfolio = Portfolio::findOrFail($id);



        $portfolio->delete();



        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus');
    }
}
