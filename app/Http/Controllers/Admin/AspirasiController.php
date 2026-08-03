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

    public function index(Request $request)
    {
        // Tandai notifikasi sidebar sudah dilihat
        ContactMessage::where('notif_sidebar', 0)
            ->update([
                'notif_sidebar' => 1
            ]);

        /*
        |--------------------------------------------------------------------------
        | QUERY ASPIRASI
        |--------------------------------------------------------------------------
        */

        $query = ContactMessage::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH NAMA / EMAIL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'is_read',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $perPage = request('per_page', 5);

        $allowedPerPage = [5, 10, 20, 50];

        if (!in_array((int) $perPage, $allowedPerPage)) {
            $perPage = 5;
        }

        $messages = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        | Statistik tetap menghitung seluruh data,
        | bukan hanya hasil pencarian.
        */

        $totalMessages = ContactMessage::count();

        $unreadMessages = ContactMessage::where(
            'is_read',
            0
        )->count();

        $readMessages = ContactMessage::where(
            'is_read',
            1
        )->count();

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

        if (request()->ajax()) {

            return response()->json([
                'success' => true
            ]);

        }

        return back()->with([
            'title' => 'Berhasil! ✅',
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

        return redirect()
            ->route('admin.messages.index')
            ->with([
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