<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSelectionStep;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationSelectionStepController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lamaran_id' => 'required|exists:lamaran,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:Interview,Test',            
            'scheduled_at' => 'required|date',
            'link' => 'required|url',
            'notes' => 'nullable|string',
        ]);

        $lamaran = Lamaran::where('user_id', $request->user_id)
        ->where('post_kerjas_id', $request->job_id)
        ->first();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ApplicationSelectionStep::create([
            'lamaran_id' => $lamaran->id,
            'title' => $request->title,
            'type' => $request->type,
            'scheduled_at' => $request->scheduled_at,
            'link' => $request->link,
            'notes' => $request->notes,
            'status' => 'On Progress',
        ]);

        return redirect()->back()->with('success', 'Undangan seleksi berhasil dikirim.');
    }
}
