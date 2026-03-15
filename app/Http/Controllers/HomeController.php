<?php

namespace App\Http\Controllers; use Illuminate\Http\Request;
class HomeController extends Controller
{
public function index()
{
// $data = [
//	'nama' => 'Budi',
// 'pekerjaan' => 'Developer',
//];
// return view('home')->with($data);
$nama = "Teddy";
$pekerjaan = "programmer";
$alamat = "Jl. Merdeka No. 123";
$telepon = "08123456789";
return view('home', compact('nama', 'pekerjaan', 'alamat', 'telepon'));
}
public function contact()
{
return view('contact');
}
}
