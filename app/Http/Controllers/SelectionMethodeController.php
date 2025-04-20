<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectionMethodeController extends Controller
{
    public function index()
    {
        $selectionMethods = SelectionMethod::all();
        return view('jobsubmit.index', compact('selectionMethods'));
    }
}
