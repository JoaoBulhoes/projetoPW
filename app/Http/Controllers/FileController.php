<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('files.index', compact('files'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $files = File::where('name', 'LIKE', "%$keyword%")->get();

        return view('files.index', compact('files'));
    }
}

