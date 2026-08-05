<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\SecurityInputService;
use App\Services\Security\DangerousInputException;
use Illuminate\Support\Facades\Crypt;

class FaqController extends Controller
{
    protected SecurityInputService $security;

    public function __construct(SecurityInputService $security)
    {
        $this->security = $security;
    }

    public function index(Request $request)
    {
        $query = Faq::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('question', 'like', '%' . $request->search . '%')
                ->orWhere('answer', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        switch ($request->sort) {

            case 'oldest':
                $query->oldest();
                break;

            case 'question_asc':
                $query->orderBy('question', 'asc');
                break;

            case 'question_desc':
                $query->orderBy('question', 'desc');
                break;

            default:
                $query->orderBy('display_order')
                    ->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 5);

        $faqs = $query
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.faq.faq', compact('faqs'));
    }

    public function create()
    {
        $nextOrder = (\App\Models\Faq::max('display_order') ?? 0) + 1;

        return view('admin.faq.create', compact('nextOrder'));
    }

    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);

        $faq = Faq::findOrFail($id);

        return view('admin.faq.edit', compact('faq'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'      => 'required|string|max:255',
            'answer'        => 'required|string',
            'display_order' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('faqs', 'display_order'),
            ],
        ],[
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required' => 'Jawaban wajib diisi.',
            'display_order.required' => 'Urutan tampil wajib diisi.',
            'display_order.integer' => 'Urutan tampil harus berupa angka.',
            'display_order.min' => 'Urutan tampil minimal 1.',
            'display_order.unique' => 'Urutan tampil sudah digunakan. Silakan gunakan nomor lain atau ubah urutan FAQ yang sudah ada.',
        ]);
        $plainAnswer = trim(strip_tags($validated['answer']));

        if ($plainAnswer === '') {
            return back()
                ->withInput()
                ->withErrors([
                    'answer' => 'Jawaban wajib diisi.'
                ]);
        }
        try {

            $question = $this->security->cleanText($validated['question']);

            $answer = $this->security->cleanHtml($validated['answer']);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }

        Faq::create([
            'question'      => $question,
            'answer'        => $answer,
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan.')
            ->with('title', 'Berhasil!');
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);

        $faq = Faq::findOrFail($id);
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'display_order' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('faqs', 'display_order')->ignore($faq->id),
            ],
        ],[
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required' => 'Jawaban wajib diisi.',
            'display_order.required' => 'Urutan tampil wajib diisi.',
            'display_order.integer' => 'Urutan tampil harus berupa angka.',
            'display_order.min' => 'Urutan tampil minimal 1.',
            'display_order.unique' => 'Urutan tampil sudah digunakan. Silakan gunakan nomor lain atau ubah urutan FAQ yang sudah ada.',
        ]);
        $plainAnswer = trim(strip_tags($validated['answer']));

        if ($plainAnswer === '') {
            return back()
                ->withInput()
                ->withErrors([
                    'answer' => 'Jawaban wajib diisi.'
                ]);
        }
        try {

            $question = $this->security->cleanText($validated['question']);

            $answer = $this->security->cleanHtml($validated['answer']);

        } catch (DangerousInputException $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }

        $faq->update([
            'question'      => $question,
            'answer'        => $answer,
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.')
            ->with('title', 'Berhasil!');
    }

    public function destroy(string $id)
    {
        $id = Crypt::decryptString($id);

        $faq = Faq::findOrFail($id);

        $faq->delete();

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus.')
            ->with('title', 'Berhasil!');
    }
}
