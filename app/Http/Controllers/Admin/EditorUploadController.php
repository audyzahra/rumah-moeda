<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditorUploadController extends Controller
{
    /**
     * Upload image from Tiptap Editor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120', // Maksimal 5 MB
            ],
        ]);

        try {

            $image = $request->file('image');

            $extension = $image->getClientOriginalExtension();

            $filename = Str::uuid() . '.' . $extension;

            $path = $image->storeAs(
                'editor',
                $filename,
                'public'
            );

            return response()->json([
                'success'  => true,
                'location' => Storage::url($path), // Untuk TinyMCE
                'url'      => Storage::url($path), // Untuk Tiptap
                'filename' => $filename,
            ], 200);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Upload gambar gagal.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);

        }
    }
}
