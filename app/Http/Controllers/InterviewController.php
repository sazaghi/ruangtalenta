<?php

namespace App\Http\Controllers;

use App\Models\Interview;  // Import the Interview model

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:post_kerjas,id',
            'jadwal' => 'required|date',
            'link' => 'required|url',
        ]);
    
        Interview::create([
            'user_id' => $request->user_id,
            'post_kerjas_id' => $request->job_id,
            'tipe' => $request->judul,
            'metode' => $request->type,
            'jadwal' => $request->jadwal,
            'link' => $request->link,
            'notes' => $request->message,
            'status' => 'On Progress',
        ]);
    
        return redirect()->back()->with('success', 'Undangan interview berhasil dikirim.');
    }
    public function showCalendar()
    {
        $interviews = Interview::with('postKerja', 'user')->get();

        // Format data jadi lebih ringan untuk Blade
        $events = $interviews->map(function ($interview) {
            return [
                'id' => $interview->id,
                'date' => Carbon::parse($interview->jadwal)->format('Y-m-d'),
                'time' => Carbon::parse($interview->jadwal)->format('H:i'),
                'title' => $interview->tipe,
                'user_id' => $interview->user_id,
                'type' => 'Company', // atau bisa Friend jika user_id == Auth::id()
                'link' => $interview->link,
            ];
        });
        return view('jadwal.index', [
            'events' => $events,
        ]);
    }
    public function edit($id)
    {
        $interview = Interview::findOrFail($id);
        return view('jobsubmit.interedit', compact('interview'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal' => 'required|date',
            'link' => 'nullable|url',
            'metode' => 'required|string',
            'tipe' => 'required|string',
        ]);

        $interview = Interview::findOrFail($id);
        $interview->update($request->all());

        return redirect()->back()->with('success', 'Interview berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $interview = Interview::findOrFail($id);
        $interview->delete();

        return redirect()->back()->with('success', 'Interview berhasil dihapus.');
    }
    public function storeNote(Request $request, $id)
    {
        $interview = Interview::findOrFail($id);
        $interview->result_note = $request->result_note;
        $interview->save();

        return back()->with('success', 'Catatan berhasil disimpan.');
    }
    public function updateNote(Request $request, $id)
    {
        $interview = Interview::findOrFail($id);

        $interview->status = $request->status;

        $interview->save();

        return back()->with('success', 'Catatan berhasil disimpan dan status diperbarui.');
    }


}
