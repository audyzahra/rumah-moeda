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
        $messages = ContactMessage::latest()->get();

        $totalMessages = ContactMessage::count();

        $unreadMessages = ContactMessage::where('is_read',0)->count();

        $readMessages = ContactMessage::where('is_read',1)->count();

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

    public function markAsRead(ContactMessage $aspirasi)
    {
        $aspirasi->update([

            'is_read'=>1

        ]);

        return back()->with(

            'success',

            'Aspirasi berhasil ditandai sudah dibaca.'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(ContactMessage $aspirasi)
    {
        $aspirasi->delete();

        return back()->with(

            'success',

            'Aspirasi berhasil dihapus.'

        );
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
