<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\PostKerja;
use App\Models\Interview;
use App\Models\Bio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LamaranController extends Controller
{   
    private function calculateSimilarity(array $userSkills, array $jobSkills): float
    {
        $allSkills = array_unique(array_merge($userSkills, $jobSkills));
        if (empty($allSkills)) return 0;

        $vecA = array_map(fn($skill) => in_array($skill, $userSkills) ? 1 : 0, $allSkills);
        $vecB = array_map(fn($skill) => in_array($skill, $jobSkills) ? 1 : 0, $allSkills);

        $dot = array_sum(array_map(fn($x, $y) => $x * $y, $vecA, $vecB));
        $normA = sqrt(array_sum(array_map(fn($x) => $x * $x, $vecA)));
        $normB = sqrt(array_sum(array_map(fn($x) => $x * $x, $vecB)));

        return ($normA * $normB) == 0 ? 0 : $dot / ($normA * $normB);
    }

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

        // Ambil skill dari tabel bios
        $bio = Bio::where('user_id', $user->id)->first();
        $userSkills = $bio ? json_decode($bio->skills ?? '[]', true) : [];
        $jobSkills = $job->skills ?? [];

        
        // Normalisasi lowercase biar aman
        $userSkills = array_map('strtolower', $userSkills);
        $jobSkills = array_map('strtolower', $jobSkills);

        $score = $this->calculateSimilarity($userSkills, $jobSkills);

        // Simpan aplikasi
        Lamaran::create([
            'user_id' => $user->id,
            'post_kerjas_id' => $job->id,
            'status' => 'pending',
            'score' => round($score * 100), // bisa dikali 100 biar keliatan persentase
        ]);

        return back()->with('success', 'Job application submitted successfully.');
    }

    public function tracking()
    {
        $lamarans = Lamaran::where('user_id', Auth::id())->with('postKerja')->get();
        $interview = Interview::where('user_id', Auth::id())->get();

        return view('jobtracking.tracking-lamaran', compact('lamarans','interview'));
    }
    public function reject(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'message' => 'nullable|string',
        ]);

        $lamaran = \App\Models\Lamaran::where('user_id', $request->user_id)
            ->where('job_id', $request->job_id)
            ->first();

        if ($lamaran) {
            $lamaran->status = 'rejected';
            $lamaran->save();

            // Kirim email penolakan opsional
            // Mail::to($lamaran->user->email)->send(new ApplicationRejectedMail(...));

            return redirect()->back()->with('success', 'Lamaran berhasil ditolak.');
        }

        return redirect()->back()->with('error', 'Lamaran tidak ditemukan.');
    }
}
