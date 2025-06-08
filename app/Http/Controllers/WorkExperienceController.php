<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkExperienceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        WorkExperience::create([
            'user_id' => Auth::id(),
            'company' => $request->company,
            'position' => $request->position,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->back()->with('success', 'Work experience added.');
    }

    public function destroy($id)
    {
        $experience = WorkExperience::findOrFail($id);
        $experience->delete();

        return redirect()->back()->with('success', 'Work experience deleted.');
    }
}

