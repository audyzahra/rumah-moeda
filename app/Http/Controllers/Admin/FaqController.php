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
                    ->orderBy('created_at','desc')
                    ->get();

        return view('admin.faq.faq', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'=>'required|max:255',
            'answer'=>'required',
            'display_order'=>'nullable|integer'
        ]);

        Faq::create([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'display_order'=>$request->display_order ?? 0
        ]);

        return back()->with('success','FAQ berhasil ditambahkan.');
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question'=>'required|max:255',
            'answer'=>'required',
            'display_order'=>'nullable|integer'
        ]);

        $faq->update([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'display_order'=>$request->display_order ?? 0
        ]);

        return back()->with('success','FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success','FAQ berhasil dihapus.');
    }
}