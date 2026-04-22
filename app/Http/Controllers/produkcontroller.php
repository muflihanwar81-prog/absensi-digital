<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Fungsi ambil data
    public function getData()
    {
        $data = [
            ['id' => 1, 'nama' => 'Indomie', 'harga' => 3000],
            ['id' => 2, 'nama' => 'Teh Botol', 'harga' => 5000],
            ['id' => 3, 'nama' => 'Roti', 'harga' => 4000],
        ];

        return $data;
    }

    // Fungsi tampilkan view
    public function test()
{
    $data = $this->getData();
    return view('test', compact('data'));
}
}