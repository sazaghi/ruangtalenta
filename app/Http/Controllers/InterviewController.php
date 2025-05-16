<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Lamaran;
use App\Models\SelectionTemplate;
use App\Models\SelectionStage;

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
            'selection_template_id' => 'required|exists:selection_templates,id',
            'jadwal' => 'required|date',
            'link' => 'required|url',
        ]);

        // Ambil nama tahap dari selection_templates
        $template = SelectionTemplate::findOrFail($request->selection_template_id);
        $stage = SelectionStage::where('stage_name', $template->stage_name)->first();

        // Simpan interview
        Interview::create([
            'user_id' => $request->user_id,
            'post_kerjas_id' => $request->job_id,
            'selection_template_id' => $request->selection_template_id,
            'tipe' => $request->judul,
            'metode' => $request->type,
            'jadwal' => $request->jadwal,
            'link' => $request->link,
            'notes' => $request->message,
            'status' => 'On Progress',
        ]);

        // Update lamaran
        Lamaran::where('user_id', $request->user_id)
            ->where('post_kerjas_id', $request->job_id)
            ->update([
                'status' => 'Scheduled',
                'current_stage_id' => $stage?->id,
            ]);

        return redirect()->back()->with('success', 'Undangan interview berhasil dikirim.');
    }
    public function showCalendar()
    {
        $interviews = Interview::with('postKerja', 'user')->get();

        $events = $interviews->map(function ($interview) {
            return [
                'id' => $interview->id,
                'date' => Carbon::parse($interview->jadwal)->format('Y-m-d'),
                'time' => Carbon::parse($interview->jadwal)->format('H:i'),
                'title' => $interview->tipe,
                'user_id' => $interview->user_id,
                'type' => 'Company',
                'status'=>  $interview->status,
                'result_note' => $interview->result_note,
                'link' => $interview->link,
            ];
        });
        return view('jadwal.index', [
            'events' => $events,
        ]);
    }
    public function userShowCalendar()
    {
        $userId = Auth::id();

        $interviews = Interview::with('postKerja', 'user')
            ->where('user_id', $userId)
            ->get();

        $events = $interviews->map(function ($interview) {
            return [
                'id' => $interview->id,
                'date' => Carbon::parse($interview->jadwal)->format('Y-m-d'),
                'time' => Carbon::parse($interview->jadwal)->format('H:i'),
                'title' => $interview->tipe,
                'user_id' => $interview->user_id,
                'type' => 'Company',
                'status' => $interview->status,
                'result_note' => $interview->notes,
                'link' => $interview->link,
            ];
        });

        return view('jadwal.indexpencarikerja', [
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

    $interview->result_note = $request->result_note;
    $interview->status = 'Reviewed'; // atau apapun statusnya
    $interview->save();

    // Update status lamaran
    Lamaran::where('user_id', $interview->user_id)
        ->where('post_kerjas_id', $interview->post_kerjas_id)
        ->update([
            'status' => 'Checking Result',
        ]);

    return back()->with('success', 'Catatan berhasil disimpan dan status diperbarui.');
}

public function finalize(Request $request, $Id)
{
    dd($request);
    $application = Lamaran::findOrFail($Id);
    $status = $request->input('status');
    

    $application->status = $status;
    $application->save();

    return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui.');
}





}
