<?php

namespace App\Http\Controllers;

use App\Models\PostKerja;
use App\Models\SelectionMethod;
use App\Models\Interview;
use App\Models\Lamaran;
use App\Models\Bio;
use App\Models\Category;
use App\Models\SelectionTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{   
    public function store(Request $request)
    {   
        $user = Auth::user();
        if (!$user->hasRole('perusahaan')) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk memposting pekerjaan.'], 403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id', // Pastikan category_id ada di tabel categories
            'title' => 'required|string|max:255',
            'description' => 'required',
            'salary_min' => 'nullable|integer|min:0',
            'salary_max' => 'nullable|integer|gte:salary_min',
            'selection_methods' => 'array',
            'location' => 'nullable|string',
            'experience' => 'nullable|integer',
            'job_type' => 'nullable|string',
            'deadline' => 'nullable|date',
            'skills' => 'nullable|string',
        ]);
        
        
        $skillsArray = null;
        if ($request->filled('skills')) {
            $skillsArray = array_map('trim', explode(',', $request->skills));
        }
        
        $job = PostKerja::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'selection_methods' => $request->input('selection_methods', []),
            'location' => $request->location,
            'experience' => $request->experience,
            'job_type' => $request->job_type,
            'deadline' => $request->deadline,
            'skills' => $skillsArray,
            'category_id' => $request->category_id,  // Simpan kategori yang dipilih
        ]);

        if ($request->filled('selection_stages')) {
            foreach ($request->selection_stages as $index => $stage) {
                SelectionTemplate::create([
                    'post_kerjas_id' => $job->id,
                    'stage_order' => $index + 1,
                    'stage_name' => $stage['name'],
                ]);
            }
        }
                
        return redirect()->back()->with('success', 'Job posted successfully!');
    }

    public function index()
    {
        $jobs = PostKerja::with(['lamarans.user', 'selectionSteps'])
        ->where('user_id', auth()->id())
        ->get();

        $activeCount = $jobs->where('status', 'active')->count();
        $inactiveCount = $jobs->where('status', 'inactive')->count();

        $categories = Category::all();
        $selectionMethods = SelectionMethod::all();
        return view('jobsubmit.index', compact('jobs', 'selectionMethods','categories','activeCount','inactiveCount'));
    }

    public function show()
    {
        $jobs = PostKerja::latest()->get();
        $locations = PostKerja::select('location')->distinct()->pluck('location');
        $categories = Category::latest()->get();
        $skills = PostKerja::select('skills')->get()
            ->pluck('skills')
            ->flatten()
            ->unique()
            ->filter()
            ->values(); 
        return view('jobsubmit.filterjob', compact('jobs', 'locations', 'skills','categories'));
    }

    public function filtering(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('pencarikerja')) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengapply pekerjaan.'], 403);
        }

        $query = PostKerja::query();

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('location')) {
            $query->whereIn('location', $request->location);
        }

        if ($request->filled('salary_min')) {
            $query->where('salary_max', '>=', $request->salary_min);
        }
        
        if ($request->filled('salary_max')) {
            $query->where('salary_min', '<=', $request->salary_max);
        }        

        if ($request->filled('experience_min')) {
            $query->where('experience', '>=', $request->experience_min);
        }

        if ($request->filled('experience_max')) {
            $query->where('experience', '<=', $request->experience_max);
        }

        if ($request->filled('skills')) {
            $skills = $request->skills;
            $query->where(function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere('skills', 'like', '%' . $skill . '%');
                }
            });
        }

        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }

        // Sorting
        if ($request->sort_by == 'newest') {
            $query->latest();
        } elseif ($request->sort_by == 'oldest') {
            $query->oldest();
        } elseif ($request->sort_by == 'recommended') {
            $userSkills = $user->skills ?? [];
            $query->where(function($q) use ($userSkills) {
                foreach ($userSkills as $skill) {
                    $q->orWhere('skills', 'like', '%' . $skill . '%');
                }
            });
            $query->latest();
        } elseif ($request->sort_by == 'default') {
            $query->latest();
        }

        $jobs = $query->paginate(10);

        $locations = PostKerja::select('location')->distinct()->pluck('location');
        $skills = PostKerja::select('skills')->get()
            ->pluck('skills')
            ->flatten()
            ->unique()
            ->filter()
            ->values();
        $categories = Category::latest()->get();

        return view('jobsubmit.filterjob', compact('jobs', 'locations', 'skills', 'categories'));
    }



    public function edit($id)
    {
        $job = PostKerja::findOrFail($id);

        if (auth()->user()->id !== $job->user_id) {
            abort(403);
        }

        return view('jobsubmit.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = PostKerja::findOrFail($id);

        if (auth()->user()->id !== $job->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'salary' => 'required|numeric',
            'location' => 'nullable|string',
            'experience' => 'nullable|integer',
            'job_type' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary,
            'location' => $request->location,
            'experience' => $request->experience,
            'job_type' => $request->job_type,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('job.index')->with('success', 'Job updated!');
    }

    public function candidate(Request $request)
    {
        $jobs = PostKerja::all();

        $selectedJob = null;
        if ($request->has('job_id')) {
            $selectedJob = PostKerja::with('lamarans.user')->find($request->job_id);
        }

        $interviews = collect();
        $selectiontemplate = collect();
        $pendingCount = 0;
        $acceptedCount = 0;
        $rejectedCount = 0;
        $shortlistCount = 0;

        if ($selectedJob) {
            $interviews = Interview::where('post_kerjas_id', $selectedJob->id)->get()->groupBy('user_id');
            $selectiontemplate = SelectionTemplate::where('post_kerjas_id', $selectedJob->id)->get();
            $pendingCount = $selectedJob->lamarans()->where('status', 'pending')->count();
            $acceptedCount = $selectedJob->lamarans()->where('status', 'accepted')->count();
            $rejectedCount = $selectedJob->lamarans()->where('status', 'Rejected')->count();
            $shortlistCount = $selectedJob->lamarans()->whereNotIn('status', ['pending', 'accepted', 'Rejected'])->count();
        }

        return view('jobsubmit.candidate', compact('jobs', 'selectedJob', 'interviews','selectiontemplate', 'pendingCount', 'acceptedCount', 'rejectedCount', 'shortlistCount'));
    }

    public function destroy($id)
    {
        $job = PostKerja::findOrFail($id);
        $job->delete();

        return redirect()->route('job.index')->with('success', 'Job deleted successfully!');
    }
    public function detail($id)
    {
        $job = PostKerja::findOrFail($id);

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

        $jobKeywords = $this->extractKeywords($job->description);

        $similarities = collect($courses)->map(function ($course) use ($jobKeywords) {
            $courseKeywords = $this->extractKeywords($course['description']);
            $similarity = $this->calculateSimilarity($jobKeywords, $courseKeywords);
            return array_merge($course, ['similarity' => $similarity]);
        })->sortByDesc('similarity')->take(3)->values();

        return view('jobsubmit.detail', [
            'job' => $job,
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
