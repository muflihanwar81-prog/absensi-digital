<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminKelolaDivisiController extends Controller
{
    public function index()
    {
        $data = [];

        return view('admin.keloladivisi', compact('data'));
    }
}