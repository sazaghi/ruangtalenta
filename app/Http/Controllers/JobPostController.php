<?php

namespace App\Http\Controllers;

use App\Models\PostKerja;
use App\Models\Test;
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
            'selection_methods' => 'array',
            'location' => 'nullable|string',
            'experience' => 'nullable|integer',
            'job_type' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        // Simpan data ke database
        $job = PostKerja::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary ?? null, // Jika tidak diisi, tetap null
            'selection_methods' => json_encode($request->selection_methods), // Simpan sebagai JSON
            'location' => $request->location,
            'experience' => $request->experience,
            'job_type' => $request->job_type,
            'deadline' => $request->deadline,
        ]);

        return redirect()->back()->with('success', 'Job posted successfully!');
    }

    public function index()
    {
        $jobs = PostKerja::with(['lamarans.user']) // load pelamar + user-nya
        ->where('user_id', auth()->id())
        ->get();

        return view('jobsubmit.index', compact('jobs'));
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
    public function destroy($id)
    {
        $job = PostKerja::findOrFail($id);
        $job->delete();

        return redirect()->route('job.index')->with('success', 'Job deleted successfully!');
    }
}
