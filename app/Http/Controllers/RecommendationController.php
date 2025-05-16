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

    public function rekomendasi($job_id)
    {
        $job = PostKerja::findOrFail($job_id);
        $deskripsi = $job->description;

        // Data kursus dummy
        $courses = [
            [
                'title' => 'Fullstack Web Development',
                'link' => 'https://dummy-link.com/fullstack-web',
                'description' => 'Pelajari pembuatan website dari front-end hingga back-end.'
            ],
            [
                'title' => 'Data Science with Python',
                'link' => 'https://dummy-link.com/data-science-python',
                'description' => 'Analisis data dan machine learning menggunakan Python.'
            ],
            [
                'title' => 'Digital Marketing Fundamentals',
                'link' => 'https://dummy-link.com/digital-marketing',
                'description' => 'Dasar-dasar pemasaran digital seperti SEO, SEM, dan social media marketing.'
            ],
            [
                'title' => 'UI/UX Design Basics',
                'link' => 'https://dummy-link.com/ui-ux-design',
                'description' => 'Dasar-dasar desain antarmuka dan pengalaman pengguna.'
            ],
            [
                'title' => 'Cloud Computing with AWS',
                'link' => 'https://dummy-link.com/cloud-aws',
                'description' => 'Belajar infrastruktur cloud dan layanan AWS.'
            ],
        ];

        $courseList = collect($courses)->map(function ($course, $i) {
            return ($i + 1) . ". {$course['title']} - {$course['description']}";
        })->implode("\n");

        $prompt = "Berikut adalah deskripsi pekerjaan:\n\n{$deskripsi}\n\n" .
                "Berikut adalah daftar kursus yang tersedia:\n\n{$courseList}\n\n" .
                "Tolong rekomendasikan 3 kursus yang paling relevan untuk pekerjaan ini dan jelaskan alasannya.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama3-70b-8192',
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah sistem rekomendasi kursus berdasarkan pekerjaan.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $rekomendasi = $response->successful() ? $response->json()['choices'][0]['message']['content'] : 'Gagal mendapatkan rekomendasi.';

        return response()->json([
            'job' => $job->title,
            'rekomendasi' => $rekomendasi,
        ]);
    }

    public function rekomendasi2($job_id)
{
    $job = PostKerja::findOrFail($job_id);
    $deskripsi = $job->description;

    $courses = [
        [
            'title' => 'Fullstack Web Development',
            'link' => 'https://dummy-link.com/fullstack-web',
            'description' => 'Pelajari HTML, CSS, JavaScript, PHP, dan MySQL untuk membangun website end-to-end.'
        ],
        [
            'title' => 'Data Science with Python',
            'link' => 'https://dummy-link.com/data-science-python',
            'description' => 'Belajar analisis data, machine learning, dan Python libraries seperti Pandas, NumPy, dan Scikit-Learn.'
        ],
        [
            'title' => 'UI/UX Design Basics',
            'link' => 'https://dummy-link.com/ui-ux-design',
            'description' => 'Mempelajari prinsip-prinsip desain antarmuka pengguna dan pengalaman pengguna.'
        ],
        [
            'title' => 'Backend Development with Node.js',
            'link' => 'https://dummy-link.com/backend-node',
            'description' => 'Belajar membuat REST API menggunakan Node.js, Express, dan MongoDB.'
        ],
    ];

    $jobKeywords = $this->extractKeywords($deskripsi);

    $similarities = collect($courses)->map(function ($course) use ($jobKeywords) {
        $courseKeywords = $this->extractKeywords($course['description']);
        $similarity = $this->calculateSimilarity($jobKeywords, $courseKeywords);
        return array_merge($course, ['similarity' => $similarity]);
    })->sortByDesc('similarity')->take(3)->values();

    return response()->json([
        'job' => $job->title,
        'rekomendasi' => $similarities,
    ]);
}

private function extractKeywords($text)
{
    $stopWords = ['yang', 'dan', 'dengan', 'untuk', 'dari', 'di', 'ke', 'adalah', 'serta', 'ini', 'itu', 'pada', 'oleh'];
    $words = str_word_count(strtolower(strip_tags($text)), 1);
    $keywords = array_filter($words, function($word) use ($stopWords) {
        return !in_array($word, $stopWords) && strlen($word) > 3;
    });
    return array_unique($keywords);
}

private function calculateSimilarity($keywords1, $keywords2)
{
    $allKeywords = array_unique(array_merge($keywords1, $keywords2));
    $vector1 = [];
    $vector2 = [];

    foreach ($allKeywords as $keyword) {
        $vector1[] = in_array($keyword, $keywords1) ? 1 : 0;
        $vector2[] = in_array($keyword, $keywords2) ? 1 : 0;
    }

    $dotProduct = array_sum(array_map(function($a, $b) { return $a * $b; }, $vector1, $vector2));
    $magnitude1 = sqrt(array_sum(array_map(fn($a) => $a * $a, $vector1)));
    $magnitude2 = sqrt(array_sum(array_map(fn($a) => $a * $a, $vector2)));

    if ($magnitude1 == 0 || $magnitude2 == 0) {
        return 0;
    }

    return $dotProduct / ($magnitude1 * $magnitude2);
}


}