<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'link' => 'required|url',
            'message' => 'nullable|string',
        ]);

        $lamaran = \App\Models\Lamaran::where('user_id', $request->user_id)
            ->where('job_id', $request->job_id)
            ->first();

        if ($lamaran) {
            $lamaran->test_link = $request->link;
            $lamaran->status = 'test'; // opsional: ubah status
            $lamaran->save();
        }

        return redirect()->back()->with('success', 'Link tes berhasil disimpan.');
    }
}
