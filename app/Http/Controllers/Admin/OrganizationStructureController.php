<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\OrganizationStructureExport;
use App\Imports\OrganizationStructureImport;
use Maatwebsite\Excel\Facades\Excel;

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
        switch ($request->sort) {

            case 'nama_asc':
                $query->orderBy('full_name', 'asc');
                break;

            case 'nama_desc':
                $query->orderBy('full_name', 'desc');
                break;

            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;

            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;

            default:
                $query->orderBy('parent_id')
                    ->orderBy('full_name');
                break;
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
        $parents = OrganizationStructure::orderBy('full_name')->get();

        return view('admin.struktur.tambah', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:organization_structures,id',
            'full_name' => 'required|max:100',
            'position' => 'required|max:100',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string'
        ]);

        $photo = $request->file('photo')
            ->store('struktur', 'public');

        OrganizationStructure::create([
            'parent_id'   => $request->parent_id,
            'full_name' => $request->full_name,
            'position' => $request->position,
            'photo' => $photo,
            'description' => $request->description
        ]);

        return redirect()
            ->route('admin.organization-structures.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $struktur = OrganizationStructure::findOrFail($id);

        return view('admin.organization-structures.struktur', compact('struktur'));
    }

    public function edit($id)
    {
        $organization = OrganizationStructure::with('descendants')
            ->findOrFail($id);

        $excludeIds = $organization->descendants
            ->pluck('id')
            ->toArray();

        $excludeIds[] = $organization->id;
        $parents = OrganizationStructure::whereNotIn('id', $excludeIds)
            ->orderBy('full_name')
            ->get();

        return view('admin.struktur.edit', compact(
            'organization',
            'parents'
        ));
    }

    public function update(Request $request, $id)
    {
        $struktur = OrganizationStructure::findOrFail($id);

        $request->validate([
            'parent_id' => 'nullable|exists:organization_structures,id',
            'full_name' => 'required|max:100',
            'position' => 'required|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = [
            'parent_id'   => $request->parent_id,
            'full_name' => $request->full_name,
            'position' => $request->position,
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

        if ($request->filled('parent_id')) {

    $parent = OrganizationStructure::find($request->parent_id);

    $visited = [];

    while ($parent) {

        // cegah infinite loop
        if (in_array($parent->id, $visited)) {
            break;
        }

        $visited[] = $parent->id;


        // parent tidak boleh menjadi dirinya sendiri
        if ($parent->id == $struktur->id) {

            return back()
                ->withInput()
                ->withErrors([
                    'parent_id' => 'Parent yang dipilih menyebabkan struktur menjadi loop.'
                ]);
        }


        $parent = $parent->parent;
    }
}

        $struktur->update($data);

        return redirect()
    ->route('admin.organization-structures.index')
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
            ->route('admin.organization-structures.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // untuk export data struktur ke format CSV
    public function export()
    {
        return Excel::download(
            new OrganizationStructureExport,
            'struktur-organisasi.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(
            new OrganizationStructureImport,
            $request->file('file')
        );

        return redirect()
            ->route('admin.organization-structures.index')
            ->with('success', 'Data berhasil diimport.');
    }
}
