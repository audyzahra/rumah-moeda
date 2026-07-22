<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

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
        return view('admin.faq.create');
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
            'display_order' => 'nullable|integer|min:0',
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
            'question'      => 'required|string|max:255',
            'answer'        => 'required|string',
            'display_order' => 'nullable|integer|min:0',
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
