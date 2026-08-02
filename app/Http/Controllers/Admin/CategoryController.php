<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;

class CategoryController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
    /**
     * Menampilkan daftar kategori
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);

        $query = Category::withCount('news');

        // ===========================
        // SEARCH
        // ===========================
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where('name', 'like', "%{$search}%");

        }

        // ===========================
        // SORT
        // ===========================
        if ($request->filled('sort')) {

            switch ($request->sort) {

                case 'nama_asc':
                    $query->orderBy('name');
                    break;

                case 'nama_desc':
                    $query->orderByDesc('name');
                    break;

                case 'terbaru':
                    $query->latest();
                    break;

                case 'terlama':
                    $query->oldest();
                    break;
            }

        } else {

            $query->latest();

        }

        $categories = $query
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'admin.kategori.index',
            compact('categories')
        );
    }

    /**
     * Halaman tambah kategori
     */
    public function create()
    {
        return view('admin.kategori.tambah');
    }

    /**
     * Simpan kategori
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        try {

            $name = $this->security->cleanText($request->name);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        Category::create([
            'name' => $name,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with([
                'title' => 'Berhasil! 🎉',
                'success' => 'Kategori berhasil ditambahkan.'
            ]);
    }

    /**
     * Detail kategori
     */
    public function show($id)
    {
        $category = Category::withCount('news')
            ->findOrFail($id);

        return view('admin.kategori.detail', compact('category'));
    }

    /**
     * Halaman edit kategori
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.kategori.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        try {

            $name = $this->security->cleanText($request->name);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $category->update([
            'name' => $name,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with([
                'title' => 'Berhasil! 🎉',
                'success' => 'Kategori berhasil diperbarui.'
            ]);
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $category = Category::withCount('news')
            ->findOrFail($id);

        // Jangan hapus jika masih dipakai berita
        if ($category->news_count > 0) {

            return redirect()
                ->route('admin.categories.index')
                ->with([
                    'error' => 'Kategori tidak dapat dihapus karena masih digunakan oleh berita.'
                ]);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with([
                'title' => 'Berhasil Dihapus 🗑️',
                'success' => 'Kategori berhasil dihapus.'
            ]);
    }
}
