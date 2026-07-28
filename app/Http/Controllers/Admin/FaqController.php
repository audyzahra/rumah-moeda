<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('admin.faq.faq', compact('faqs'));
    }

    public function create()
    {
        $nextOrder = (\App\Models\Faq::max('display_order') ?? 0) + 1;

        return view('admin.faq.create', compact('nextOrder'));
    }

    public function edit(Faq $faq)
    {
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

        Faq::create([
            'question'      => $validated['question'],
            'answer'        => $validated['answer'],
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan.')
            ->with('title', 'Berhasil!');
    }

    public function update(Request $request, Faq $faq)
    {
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

        $faq->update([
            'question'      => $validated['question'],
            'answer'        => $validated['answer'],
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.')
            ->with('title', 'Berhasil!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus.')
            ->with('title', 'Berhasil!');
    }
}
