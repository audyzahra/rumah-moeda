<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('hubungi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|max:255',
            'phone'     => 'required|max:20',
            'email'     => 'required|email|max:255',
            'message'   => 'required'
        ]);

        ContactMessage::create([
            'full_name' => $request->full_name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'message'   => $request->message,
            'is_read'   => false,
        ]);

        return back()->with('success','Pesan berhasil dikirim.');
    }
}
