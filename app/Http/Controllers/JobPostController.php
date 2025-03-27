<?php

namespace App\Http\Controllers;

use App\Models\PostKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('perusahaan')) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk memposting pekerjaan.'], 403);
        }

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'salary' => 'nullable|integer',
        ]);

        // Simpan data ke database
        PostKerja::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary ?? null, // Jika tidak diisi, tetap null
        ]);

        return redirect()->back()->with('success', 'Job posted successfully!');
    }

    public function index()
    {
        return response()->json(PostKerja::all());
    }
}
