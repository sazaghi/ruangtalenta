<?php

namespace App\Http\Controllers;
use App\Models\Education;

use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'major' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'year' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Education::create([
            'user_id' => auth()->id(),
            'major' => $request->major,
            'university' => $request->university,
            'year' => $request->year,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Education added successfully.');
    }
    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return redirect()->back()->with('success', 'Data pendidikan berhasil dihapus.');
    }


}
