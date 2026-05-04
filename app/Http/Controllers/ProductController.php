<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = [
                ['id' => 1, 'produk' => 'kucing imut'],
                ['id' => 2, 'produk' => 'kucing aneh'],
                ['id' => 3, 'produk' => 'kucing lucu'],
        ];
        return view('list_product', ['data' => $data]);
    }
}
