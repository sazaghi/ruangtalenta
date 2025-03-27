<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\PostKerja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LamaranController extends Controller
{
    public function store(Request $request, $jobId)
    {
        $user = Auth::user();
        if (!$user->hasRole('pencarikerja')) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengaply pekerjaan.'], 403);
        }

        $job = PostKerja::findOrFail($jobId);

        // Cek apakah user sudah apply sebelumnya
        if (Lamaran::where('user_id', $user->id)->where('post_kerjas_id', $jobId)->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        // Simpan aplikasi
        Lamaran::create([
            'user_id' => $user->id,
            'post_kerjas_id' => $job->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Job application submitted successfully.');
    }
    public function tracking()
    {
        $lamarans = Lamaran::where('user_id', Auth::id())->with('postKerja')->get();

        return view('jobtracking.tracking-lamaran', compact('lamarans'));
    }
}
