<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationStructureController extends Controller
{
    public function index(Request $request)
{
    $query = OrganizationStructure::query();


    // ===== SEARCH =====
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('full_name', 'like', '%' . $request->search . '%')
              ->orWhere('position', 'like', '%' . $request->search . '%');

        });

    }


    // ===== FILTER JABATAN =====
    if ($request->filled('jabatan')) {

        $query->where('position', $request->jabatan);

    }


    // ===== SORTING =====
    if ($request->sort == 'nama') {

        $query->orderBy('full_name', 'asc');

    } elseif ($request->sort == 'terbaru') {

        $query->orderBy('created_at', 'desc');

    } else {

        // default: urutan tampil
        $query->orderBy('display_order', 'asc');

    }


    // ===== DATA STRUKTUR =====
    $struktur = $query->paginate(12);


    // ===== LIST JABATAN UNTUK FILTER =====
    $jabatanList = OrganizationStructure::select('position')
        ->distinct()
        ->pluck('position');


    return view('admin.struktur.struktur', compact(
        'struktur',
        'jabatanList'
    ));
}

    public function create()
    {
        return redirect()->route('admin.struktur.struktur');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|max:100',
            'position' => 'required|max:100',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'display_order' => 'nullable|integer',
            'description' => 'nullable|string'
        ]);

        $photo = $request->file('photo')
            ->store('struktur', 'public');

        OrganizationStructure::create([
            'full_name' => $request->full_name,
            'position' => $request->position,
            'photo' => $photo,
            'display_order' => $request->display_order ?? 0,
            'description' => $request->description
        ]);

        return redirect()
            ->route('admin.struktur.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $struktur = OrganizationStructure::findOrFail($id);

        return view('admin.struktur.struktur', compact('struktur'));
    }

    public function edit($id)
    {
        $editData = OrganizationStructure::findOrFail($id);

        $struktur = OrganizationStructure::orderBy('display_order')
            ->paginate(12);

        $jabatanList = OrganizationStructure::select('position')
            ->distinct()
            ->pluck('position');

        return view('admin.struktur.struktur', compact(
            'struktur',
            'jabatanList',
            'editData'
        ));
    }

    public function update(Request $request, $id)
    {
        $struktur = OrganizationStructure::findOrFail($id);

        $request->validate([
            'full_name' => 'required|max:100',
            'position' => 'required|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'display_order' => 'nullable|integer',
            'description' => 'nullable|string'
        ]);

        $data = [
            'full_name' => $request->full_name,
            'position' => $request->position,
            'display_order' => $request->display_order ?? 0,
            'description' => $request->description,
        ];

        if ($request->hasFile('photo')) {

            if ($struktur->photo) {
                Storage::disk('public')->delete($struktur->photo);
            }

            $data['photo'] = $request
                ->file('photo')
                ->store('struktur', 'public');
        }

        $struktur->update($data);

        return redirect()
            ->route('admin.struktur.struktur')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $struktur = OrganizationStructure::findOrFail($id);

        if ($struktur->photo) {
            Storage::disk('public')->delete($struktur->photo);
        }

        $struktur->delete();

        return redirect()
            ->route('admin.struktur.index')
            ->with('success', 'Data berhasil dihapus');
    }
}