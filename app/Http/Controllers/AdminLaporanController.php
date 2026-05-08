<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $data = [];

        return view('admin.laporan', compact('data'));
    }
}