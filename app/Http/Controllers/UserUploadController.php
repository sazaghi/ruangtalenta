<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use Illuminate\Http\Request;
use App\Models\UserUpload;
use Illuminate\Support\Facades\Storage;

class UserUploadController extends Controller
{
    // Menampilkan semua file milik user
    public function index()
    {
        $userId = auth()->id();

        $lamarans = Lamaran::where('user_id', $userId)->get();

        $files = [];

        foreach ($lamarans as $lamaran) {
            if ($lamaran->resume_path) {
                $files[] = [
                    'type' => 'Resume',
                    'path' => $lamaran->resume_path,
                ];
            }

            if ($lamaran->application_letter_path) {
                $files[] = [
                    'type' => 'Application Letter',
                    'path' => $lamaran->application_letter_path,
                ];
            }
        }

        return view('user_uploads.index', [
            'files' => $files,
        ]);
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
