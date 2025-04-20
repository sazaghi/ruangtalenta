<?php

namespace App\Http\Controllers;

use App\Models\PostKerja;
use App\Models\SelectionMethod;
use App\Models\Interview;
use App\Models\Lamaran; // Tambahkan ini
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

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'salary' => 'nullable|integer',
            'selection_methods' => 'array',
            'location' => 'nullable|string',
            'experience' => 'nullable|integer',
            'job_type' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);
        
        if ($request->filled('skills')) {
            // Pisahkan skills yang dipisahkan koma menjadi array
            $skillsArray = array_map('trim', explode(',', $request->skills));
        
            // Tidak perlu lagi menggunakan json_encode, biarkan Laravel yang menangani
            $validated['skills'] = $skillsArray;
        }
        
        // Simpan data ke database
        $job = PostKerja::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary ?? null,
            'selection_methods' => $request->input('selection_methods', []), // masih disimpan di kolom job juga
            'location' => $request->location,
            'experience' => $request->experience,
            'job_type' => $request->job_type,
            'deadline' => $request->deadline,
            'skills' => $validated['skills'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Job posted successfully!');
    }

    public function index()
    {
        $jobs = PostKerja::with(['lamarans.user', 'selectionSteps'])
        ->where('user_id', auth()->id())
        ->get();

        $selectionMethods = SelectionMethod::all(); // <--- ini ambil data master metode seleksi
        return view('jobsubmit.index', compact('jobs', 'selectionMethods'));
    }

    public function show()
    {
        $jobs = PostKerja::latest()->get(); // atau tambahin filter, paginate dll
        return view('jobsubmit.filterjob', compact('jobs'));
    }

    public function alljob(Request $request)
    {
        $query = PostKerja::query();

        // Kalau ada keyword
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Kalau ada filter lokasi
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Kalau ada filter gaji
        if ($request->filled('salary')) {
            $query->where('salary', '>=', $request->salary);
        }

        $jobs = $query->latest()->paginate(10);

        return view('jobsubmit.filterjob', compact('jobs'));
    }

    public function edit($id)
    {
        $job = PostKerja::findOrFail($id);

        // Optional: pastikan hanya perusahaan yang punya job itu bisa edit
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

        $interviews = collect(); // default kosong
        if ($selectedJob) {
            $interviews = Interview::where('post_kerjas_id', $selectedJob->id)->get()->groupBy('user_id');
        }

        return view('jobsubmit.candidate', compact('jobs', 'selectedJob', 'interviews'));
    }

    public function destroy($id)
    {
        $job = PostKerja::findOrFail($id);
        $job->delete();

        return redirect()->route('job.index')->with('success', 'Job deleted successfully!');
    }
}
