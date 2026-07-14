<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Menampilkan daftar aspirasi milik user yang sedang login
     */
    public function index()
    {
        $messages = ContactMessage::where('user_id', Auth::id())
            ->latest()
            ->get();

        $totalMessages = $messages->count();

        return view(
            'user.messages.index',
            compact(
                'messages',
                'totalMessages'
            )
        );
    }
}
