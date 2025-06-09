<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use App\Models\Bio;
use Illuminate\Http\Request;

class BioController extends Controller
{
    function uploadToSupabase($file)
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $bucket = env('SUPABASE_BUCKET');
        $url = env('SUPABASE_URL') . "/storage/v1/object/$bucket/$fileName";

        $client = new Client();
        $response = $client->put($url, [
            'headers' => [
                'apikey' => env('SUPABASE_API_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                'Content-Type' => $file->getMimeType(),
            ],
            'body' => fopen($file->getRealPath(), 'r'), // lebih aman dari pada file_get_contents
        ]);

        if ($response->getStatusCode() === 200) {
            return env('SUPABASE_URL') . "/storage/v1/object/public/$bucket/$fileName";
        }

        return null;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'website' => 'nullable|url',
            'bio' => 'nullable|string',
            'experience' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'skills' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'complete_address' => 'nullable|string',
            'education' => 'nullable|string',
            'work_experience' => 'nullable|string',
        ]);

        // Ubah skills ke array lalu encode ke JSON
        if ($request->filled('skills')) {
            $validated['skills'] = $request->skills;
        }

        // Proses upload avatar
        if ($request->hasFile('avatar')) {
            $path = $this->uploadToSupabase($request->file('avatar'));
            $validated['avatar'] = $path;
        }

        $validated['user_id'] = auth()->id();

        // Cek jika user sudah memiliki bio, lakukan update, jika belum buat baru
        $bio = Bio::updateOrCreate(
            ['user_id' => auth()->id()], // kondisi pencarian, berdasarkan user_id
            $validated // data yang akan di-update atau disimpan
        );

        return redirect()->back()->with('success', 'Bio berhasil disimpan!');
    }
    public function edit()
    {
        $bio = Bio::where('user_id', auth()->id())->first();

        return view('profile.edit', compact('bio'));
    }
    
    public function storeEducation(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|string',
            'major' => 'required|string',
            'university' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $bio = Bio::firstOrCreate(['user_id' => auth()->id()]);

        $education = $bio->education ?? [];
        $education[] = $data;

        $bio->update(['education' => $education]);

        return redirect()->back()->with('success', 'Education added successfully.');
    }
    public function checkSkill(Request $request)
    {
        $skill = strtoupper(trim($request->query('skill')));
        $bio = Bio::where('user_id', auth()->id())->first();

        $existingSkills = $bio ? $bio->skills : [];

        $exists = in_array($skill, array_map('strtoupper', $existingSkills ?? []));

        return response()->json(['exists' => $exists]);
    }

}
