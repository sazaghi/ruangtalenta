<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SidebarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('perusahaan')) {
            return view('sidebarperusahaan', compact('user'));
        } elseif ($user->hasRole('pencarikerja')) {
            return view('sidebarpencarikerja', compact('user'));
        }

        return abort(403, 'Unauthorized');
    }
}
