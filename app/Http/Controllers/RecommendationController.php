<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PostKerja;
use App\Models\Lamaran;
use App\Models\Bio;

class RecommendationController extends Controller
{
    public function match($job_id, $user_id)
    {
        $job = PostKerja::findOrFail($job_id);
        $bio = Bio::where('user_id', $user_id)->firstOrFail();

        $jobSkills = is_array($job->skills) ? implode(', ', $job->skills) : implode(', ', json_decode($job->skills, true));
        $userSkills = is_array($bio->skills) ? implode(', ', $bio->skills) : implode(', ', json_decode($bio->skills, true));

        $prompt = "Bandingkan seberapa cocok skill berikut ini:\n\n"
                . "Skill dari pelamar:\n{$userSkills}\n\n"
                . "Skill yang dibutuhkan pekerjaan:\n{$jobSkills}\n\n"
                . "Berikan penilaian dari 0 sampai 100 seberapa cocok, dan beri alasan singkat.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama3-70b-8192',
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah sistem rekomendasi pekerjaan.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);
        if ($response->successful()) {
            $message = $response->json()['choices'][0]['message']['content'];
            preg_match('/\d+/', $message, $matches);
            if (isset($matches[0])) {
                $score = (int) $matches[0];
                $lamaran = Lamaran::where('post_kerjas_id', $job_id)
                                ->where('user_id', $user_id)
                                ->first();
                if ($lamaran) {
                    $lamaran->score = $score;
                    $lamaran->save();
                }
            }
        }
        return response()->json([
            'skills_pelamar' => $userSkills,
            'skills_pekerjaan' => $jobSkills,
            'hasil_rekomendasi' => $response->json(),
        ]);
    }

}