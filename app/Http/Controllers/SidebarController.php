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
            return view('sidebarperusahaan');
        } elseif ($user->hasRole('pencarikerja')) {
            return view('sidebarpencarikerja');
        }

        return abort(403, 'Unauthorized');
    }
}
