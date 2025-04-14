<?php

namespace App\Http\Controllers;
use App\Models\PostKerja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Lamaran;
use App\Models\Interview;
use App\Notifications\NewMessageNotification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('perusahaan')) {
            $recentJobs = PostKerja::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();
            // List semua job yang di-post perusahaan (buat dropdown)
            $jobList = PostKerja::where('user_id', $user->id)->get();

            return view('dashboardperusahaan', compact('user', 'recentJobs','jobList'));

        } elseif ($user->hasRole('pencarikerja')) {
            // Cek kelengkapan profil (contoh: 75%)
            $profileCompletion = 75; // Bisa kamu hitung dari field kosong di User

            // Lamaran terbaru (relasi user -> lamaran -> job)
            $recentJobs = Lamaran::with('postKerja')
                ->where('user_id', $user->id)
                ->latest()
                ->take(2)
                ->get();

            // Upcoming test/interview
            $upcomingTests = Interview::with('postKerja')
                ->where('user_id', $user->id)
                ->whereDate('jadwal', '>=', now())
                ->orderBy('jadwal')
                ->get();

            return view('dashboardpencarikerja', compact('user', 'profileCompletion', 'recentJobs', 'upcomingTests'));
        }

        return abort(403, 'Unauthorized');
    }
    public function getChartData($jobId)
    {
        // Pastikan job ini milik user yang login
        $job = PostKerja::where('id', $jobId)->where('user_id', Auth::id())->first();

        if (!$job) {
            return response()->json(['message' => 'Job not found or unauthorized'], 404);
        }

        $data = Lamaran::where('post_kerjas_id', $jobId)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'dates' => $data->pluck('date'),
            'totals' => $data->pluck('total'),
        ]);
    }

    public function sendNotification()
    {
        // Kirim notifikasi ke user yang sedang login
        $user = auth()->user();
        $user->notify(
            new NewMessageNotification('Ini adalah pesan notifikasi tes!')
        );
    
        return back()->with('success', 'Notifikasi tes telah dikirim!');
    }
}
