<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        // Reset badge sidebar karena halaman Aspirasi sudah dibuka
        ContactMessage::where('notif_sidebar', 0)
            ->update([
                'notif_sidebar' => 1
            ]);

        $messages = ContactMessage::latest()->get();

        $totalMessages = ContactMessage::count();

        $unreadMessages = ContactMessage::where('is_read', 0)->count();

        $readMessages = ContactMessage::where('is_read', 1)->count();

        return view(
            'admin.aspirasi.aspirasi',
            compact(
                'messages',
                'totalMessages',
                'unreadMessages',
                'readMessages'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MARK AS READ
    |--------------------------------------------------------------------------
    */

    public function markAsRead(ContactMessage $message)
    {
        $message->update([
            'is_read' => 1
        ]);

        return back()->with([
        'title'   => 'Berhasil! ✅',
        'success' => 'Aspirasi berhasil ditandai sudah dibaca.'
    ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with([
        'title' => 'Berhasil Dihapus 🗑️',
        'success' => 'Aspirasi berhasil dihapus.'
    ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */

    public function bulkDelete(Request $request)
    {
        ContactMessage::whereIn(
            'id',
            $request->ids
        )->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus.'
        );
    }
}
