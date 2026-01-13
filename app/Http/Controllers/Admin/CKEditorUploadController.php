<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CKEditorUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store in public disk under ckeditor folder
            $path = $file->storeAs('ckeditor', $filename, 'public');

            $url = Storage::disk('public')->url($path);

            return response()->json([
                'url' => $url,
                'uploaded' => 1,
                'fileName' => $filename,
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => [
                'message' => 'File upload failed.',
            ],
        ], 400);
    }
}
