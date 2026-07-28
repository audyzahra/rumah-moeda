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

    // ==========================
    // SEARCH
    // ==========================
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');

        });

    }

    // ==========================
    // FILTER WEBSITE
    // ==========================
    if ($request->website == 'ada') {

        $query->whereNotNull('website')
              ->where('website', '!=', '');

    }

    elseif ($request->website == 'tidak') {

        $query->where(function ($q) {

            $q->whereNull('website')
              ->orWhere('website', '');

        });

    }

    // ==========================
    // SORTING
    // ==========================
    switch ($request->sort) {

        case 'nama_az':

            $query->orderBy('name', 'asc');

            break;

        case 'nama_za':

            $query->orderBy('name', 'desc');

            break;

        default:

            $query->orderBy('display_order', 'asc');

            break;

    }

    $mitra = $query->paginate(5)->withQueryString();

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
    $request->validate([
        'name' => 'required|string|max:255',
        'website' => 'nullable|url',
        'display_order' => 'required|integer|min:1',
        'description' => 'nullable|string',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ],[
        'name.required' => 'Nama mitra wajib diisi.',
        'display_order.required' => 'Urutan tampil wajib diisi.',
        'display_order.integer' => 'Urutan tampil harus berupa angka.',
        'logo.required' => 'Logo mitra wajib diupload.',
        'logo.image' => 'File harus berupa gambar.',
        'logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, GIF atau SVG.',
        'logo.max' => 'Ukuran logo maksimal 2 MB.',
    ]);

    $data = $request->except('logo');

    if ($request->hasFile('logo')) {

        $filename = time().'_'.$request->file('logo')->getClientOriginalName();

        $data['logo'] = $request->file('logo')
            ->storeAs('partners', $filename, 'public');

    }

    Partner::create($data);

    return redirect()
        ->route('admin.partners.index')
        ->with([
            'title' => 'Berhasil! 🎉',
            'success' => 'Mitra berhasil ditambahkan.'
        ]);
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
            'display_order' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'display_order.required' => 'Urutan tampil wajib diisi.',
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

        return redirect()
        ->route('admin.partners.index')
        ->with([
            'title' => 'Berhasil! 🎉',
            'success' => 'Mitra berhasil diperbarui.'
        ]);
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

        return redirect()
        ->route('admin.partners.index')
        ->with([
            'title' => 'Berhasil Dihapus 🗑️',
            'success' => 'Mitra berhasil dihapus.'
        ]);
    }
}
