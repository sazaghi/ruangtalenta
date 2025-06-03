<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran;
use App\Models\PostKerja;

class NotificationController extends Controller
{
    public function fetch()
    {
        $user = Auth::user();

        if ($user->role === 'pencaker') {
            // Pencari kerja: notifikasi dari status lamaran
            $notifications = Lamaran::where('user_id', $user->id)
                ->whereNotNull('status')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();
        } else {
            // Perusahaan: notifikasi dari lamaran baru
            $postIds = PostKerja::where('user_id', $user->id)->pluck('id');

            $notifications = Lamaran::whereIn('post_kerjas_id', $postIds)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('components.notification-list', compact('notifications'));
    }
}
