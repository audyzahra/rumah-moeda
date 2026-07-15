<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index(Request $request)
    {
        $query = Category::withCount('news');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query
            ->orderBy('name', 'ASC')
            ->paginate(10);

        $totalCategory = Category::count();

        return view('admin.kategori.index', compact(
            'categories',
            'totalCategory'
        ));
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

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
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

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
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
                ->route('admin.kategori.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih digunakan oleh berita.'
                );
        }

        $category->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
