<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lamaran;
use App\Models\PostKerja;
use App\Models\Interview;
use App\Models\Bio;
use App\Models\SelectionTemplate;
use App\Models\SelectionStage;

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

        if (Lamaran::where('user_id', $user->id)->where('post_kerjas_id', $jobId)->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $bio = Bio::where('user_id', $user->id)->first();
        $userSkills = $bio ? json_decode($bio->skills ?? '[]', true) : [];
        $jobSkills = $job->skills ?? [];

        $userSkills = array_map('strtolower', $userSkills);
        $jobSkills = array_map('strtolower', $jobSkills);

        $score = $this->calculateSimilarity($userSkills, $jobSkills);

        $cvPath = null;
        $applicationLetterPath = null;
        $portofolioPath = null;

        if ($request->hasFile('resume_file')) {
            $cvPath = $request->file('resume_file')->store('resume', 'public');
        }
        if ($request->hasFile('application_letter_file')) {
            $applicationLetterPath = $request->file('application_letter_file')->store('application_letters', 'public');
        }


        // Simpan aplikasi
        $lamaran = Lamaran::create([
            'user_id' => $user->id,
            'post_kerjas_id' => $job->id,
            'status' => 'pending',
            'score' => round($score * 100),
            'resume_path' => $cvPath,
            'application_letter_path' => $applicationLetterPath,
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
    
    public function shortlistApplicants(Request $request)
    {
        $postKerjasId = $request->input('post_kerjas_id');
        $selectedIds = $request->input('lamaran_ids', []); // ambil ID dari checkbox

        if (empty($selectedIds)) {
            return back()->with('error', 'Pilih minimal satu kandidat terlebih dahulu.');
        }

        $selectedLamarans = Lamaran::with('user')
            ->whereIn('id', $selectedIds)
            ->where('post_kerjas_id', $postKerjasId)
            ->get();

        foreach ($selectedLamarans as $lamaran) {
            $lamaran->update(['status' => 'on_screening']);

            $templates = SelectionTemplate::where('post_kerjas_id', $lamaran->post_kerjas_id)
                            ->orderBy('stage_order')->get();

            $firstStage = null;
            foreach ($templates as $index => $template) {
                $stage = SelectionStage::create([
                    'lamarans_id' => $lamaran->id,
                    'stage_name' => $template->stage_name,
                    'status' => 'Pending',
                    'order_index' => $index + 1,
                ]);

                if ($index === 0) {
                    $firstStage = $stage;
                }
            }

            if ($firstStage) {
                $lamaran->current_stage_id = $firstStage->id;
                $lamaran->save();
            }
        }

        return back()->with('success', 'Kandidat berhasil dimasukkan ke shortlist.');
    }
    
    public function finalize(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $lamaran = Lamaran::findOrFail($id);

        $lamaran->status = $request->input('status');
        $lamaran->save();

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
    }
    // ApplicantController.php
    public function show(User $user)
    {
        $user->load(['profile', 'educations', 'workExperiences']);

        $lamaran = $user->lamarans()->latest()->first(); // atau sesuai filter

        return view('lamaran.show', compact('user', 'lamaran'));
    }
}
