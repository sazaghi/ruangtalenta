<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::orderBy('date')->get();
        return view('jadwal.index', compact('jadwals'));
    }
}

