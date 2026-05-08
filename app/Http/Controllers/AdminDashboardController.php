<?php

namespace App\Http\Controllers;

use App\Models\Divisi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDivisi = Divisi::count();

        return view('admin.dashboard', compact('totalDivisi'));
    }
}