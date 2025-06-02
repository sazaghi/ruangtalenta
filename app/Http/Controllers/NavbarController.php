<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NavbarController extends Controller {
    public function index()
{
    $user = Auth::user();

    // Contoh notifikasi: ambil lamaran user yang statusnya berubah dalam 3 hari terakhir
    $notifications = DB::table('job_applications')
        ->where('user_id', $user->id)
        ->where('updated_at', '!=', DB::raw('created_at'))
        ->orderBy('updated_at', 'desc')
        ->limit(10)
        ->get()
        ->map(function ($row) {
            return (object)[
                'title' => 'Status Lamaran Diperbarui',
                'message' => 'Status: ' . $row->status,
                'created_at' => \Carbon\Carbon::parse($row->updated_at),
            ];
        });

    $unreadCount = $notifications->count(); // contoh dummy hitung total notifikasi

    return view('layouts.app', compact('notifications', 'unreadCount'));
}

};