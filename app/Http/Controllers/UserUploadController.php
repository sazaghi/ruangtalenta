<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserUpload;
use Illuminate\Support\Facades\Storage;

class UserUploadController extends Controller
{
    // Menampilkan semua file milik user
    public function index()
    {
        $uploads = UserUpload::where('user_id', auth()->id())->latest()->get();
        return view('user_uploads.index', compact('uploads'));
    }

    // Menyimpan file upload
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file' => 'required|file|max:5120', // max 5MB
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/user_uploads', $filename);

        UserUpload::create([
            'user_id' => auth()->id(),
            'file_name' => $request->file_name,
            'file_path' => $filename,
        ]);

        return back()->with('success', 'File berhasil diupload.');
    }

    // Menghapus file
    public function destroy(UserUpload $userUpload)
    {
        if ($userUpload->user_id !== auth()->id()) {
            abort(403);
        }

        // Hapus file dari storage
        Storage::delete('public/user_uploads/' . $userUpload->file_path);
        
        // Hapus data dari DB
        $userUpload->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
