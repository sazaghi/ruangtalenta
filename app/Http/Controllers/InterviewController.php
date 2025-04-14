<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function schedule(Request $request, Lamaran $lamaran)
    {
        $request->validate([
            'tanggal_interview' => 'required|date',
            'link_meet' => 'required|url',
        ]);

        $lamaran->update([
            'tanggal_interview' => $request->tanggal_interview,
            'link_meet' => $request->link_meet,
        ]);

        return back()->with('success', 'Interview berhasil dijadwalkan!');
    }
}
