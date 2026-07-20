<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Partner::query();

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Website
        if ($request->website == 'ada') {
            $query->whereNotNull('website');
        } elseif ($request->website == 'tidak') {
            $query->whereNull('website');
        }

        // Sort
        if ($request->sort == 'nama') {
            $query->orderBy('name', 'asc');
        } elseif ($request->sort == 'terbaru') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('display_order', 'asc');
        }

        $mitra = $query->paginate(8);

        return view('admin.mitra.mitra', compact('mitra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mitra.create');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'display_order' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        // Upload logo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '_' . $logo->getClientOriginalName();
            $path = $logo->storeAs('partners', $filename, 'public');
            $data['logo'] = $path;
        }

        // Simpan ke database
        Partner::create($data);

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Mitra berhasil ditambahkan!');
    }

    /**
 * Show the form for editing the specified resource.
 */
    public function edit(Partner $mitra)
    {
        return view('admin.mitra.edit', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $mitra)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'display_order' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        // Upload logo
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($mitra->logo) {
                Storage::disk('public')->delete($mitra->logo);
            }

            $logo = $request->file('logo');
            $filename = time() . '_' . $logo->getClientOriginalName();
            $path = $logo->storeAs('partners', $filename, 'public');
            $data['logo'] = $path;
        }

        // Update database
        $mitra->update($data);

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Mitra berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $mitra)
        {
        // Delete logo
        if ($mitra->logo) {
            Storage::disk('public')->delete($mitra->logo);
        }

        $mitra->delete();

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Mitra berhasil dihapus!');
    }
}