<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Education;

class PortofolioController extends Controller
{
    public function index()
    {
        return view('portofolio');
    }

    public function uploadCV(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('cv');
        $filename = 'cv_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/cvs', $filename);

        return back()->with('success', 'CV uploaded successfully.');
    }

    public function storeEducation(Request $request)
    {
        $request->validate([
            'school' => 'required|string',
            'major' => 'required|string',
            'from' => 'required|date',
            'to' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Education::create($request->all());

        return back()->with('success', 'Education saved successfully.');
    }
}

