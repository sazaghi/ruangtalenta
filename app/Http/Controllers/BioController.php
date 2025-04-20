<?php

namespace App\Http\Controllers;

use App\Models\Bio;
use Illuminate\Http\Request;

class BioController extends Controller
{
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
            'skills' => 'nullable|string', // tambah validasi ini
        ]);

        // Ubah skills ke array lalu encode ke JSON
        if ($request->filled('skills')) {
            $skillsArray = array_map('trim', explode(',', $request->skills));
            $validated['skills'] = json_encode($skillsArray);
        }

        // Proses upload avatar
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $validated['user_id'] = auth()->id();

        Bio::create($validated);

        return redirect()->back()->with('success', 'Bio berhasil disimpan!');
    }

}
