<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;

class PortfolioCategoryController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);

        $query = PortfolioCategory::query();

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('name', 'like', "%{$search}%");
        }

        // Sort
        switch ($request->sort) {

            case 'oldest':
                $query->oldest();
                break;

            case 'az':
                $query->orderBy('name');
                break;

            case 'za':
                $query->orderByDesc('name');
                break;

            default:
                $query->latest();

        }

        $categories = $query
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'admin.portfolio-category.index',
            compact('categories')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolio-category.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                function ($attribute, $value, $fail) {

                    $slug = $this->generateSlug($value);

                    if (PortfolioCategory::where('slug', $slug)->exists()) {
                        $fail('Kategori tersebut sudah tersedia.');
                    }

                }
            ]
        ]);

        try {

            $name = $this->security->cleanText($request->name);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }

        PortfolioCategory::create([
            'name' => $name,
            'slug' => $this->generateSlug($name),
        ]);

        return redirect()
            ->route('admin.portfolio-categories.index')
            ->with('success', 'Kategori portofolio berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = PortfolioCategory::findOrFail($id);

        return view('admin.portfolio-category.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = PortfolioCategory::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                function ($attribute, $value, $fail) use ($category) {

                    $slug = $this->generateSlug($value);

                    if (
                        PortfolioCategory::where('slug', $slug)
                            ->where('id', '!=', $category->id)
                            ->exists()
                    ) {

                        $fail('Kategori tersebut sudah tersedia.');

                    }

                }
            ]
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
            'slug' => $this->generateSlug($name),
        ]);

        return redirect()
            ->route('admin.portfolio-categories.index')
            ->with('success', 'Kategori portofolio berhasil diperbarui');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = PortfolioCategory::findOrFail($id);


        $category->delete();



        return redirect()
            ->route('admin.portfolio-categories.index')
            ->with('success', 'Kategori portofolio berhasil dihapus');
    }



    // SLUG MAPPING

private function generateSlug(string $name): string
{
    $translations = [

        // Profil Perusahaan
        'tentang perusahaan'       => 'about-company',
        'profil perusahaan'        => 'company-profile',
        'visi misi'                => 'vision-mission',
        'sejarah perusahaan'       => 'company-history',

        // Teknologi
        'website'                  => 'website',
        'pengembangan website'     => 'website-development',
        'aplikasi web'             => 'web-application',
        'aplikasi mobile'          => 'mobile-application',
        'aplikasi seluler'         => 'mobile-application',
        'sistem informasi'         => 'information-system',
        'internet of things'       => 'internet-of-things',
        'iot'                      => 'internet-of-things',
        'artificial intelligence'  => 'artificial-intelligence',
        'kecerdasan buatan'        => 'artificial-intelligence',

        // Desain
        'ui ux'                    => 'ui-ux',
        'ui/ux'                    => 'ui-ux',
        'desain ui ux'             => 'ui-ux-design',
        'desain antarmuka'         => 'user-interface-design',
        'desain pengalaman pengguna'=> 'user-experience-design',
        'branding'                 => 'branding',
        'desain grafis'            => 'graphic-design',

        // Multimedia
        'fotografi'                => 'photography',
        'videografi'               => 'videography',
        'video'                    => 'video',
        'animasi'                  => 'animation',

        // Bisnis
        'pemasaran'                => 'marketing',
        'digital marketing'        => 'digital-marketing',
        'keuangan'                 => 'finance',
        'manajemen'                => 'management',

        // Program
        'pelatihan'                => 'training',
        'workshop'                 => 'workshop',
        'seminar'                  => 'seminar',
        'pengabdian masyarakat'    => 'community-service',
        'csr'                      => 'corporate-social-responsibility',
        'kerja sama'               => 'partnership',
        'kolaborasi'               => 'collaboration',
        'magang'                   => 'internship',
        'penelitian'               => 'research',

    ];

    $key = Str::lower(trim($name));

    if (array_key_exists($key, $translations)) {
        return $translations[$key];
    }

    return Str::slug($name);
}


// buat biar generate slug nya terlihat sebelum simpan
public function generateSlugPreview($name)
{
    return response()->json([
        'slug' => $this->generateSlug($name)
    ]);
}
}
