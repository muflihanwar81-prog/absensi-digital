<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<!-- NAV -->
<nav class="bg-white border-b shadow-sm px-6 py-3 flex justify-between items-center">
    <h1 class="text-xl font-bold">Absensi Digital</h1>
</nav>

<div class="flex">

<!-- SIDEBAR -->
<aside class="w-64 h-screen bg-white shadow-md p-5">
    <ul class="space-y-4">
        <li><a href="/dashboard" class="p-2 block">Dashboard</a></li>
        <li><a href="/karyawan" class="p-2 block bg-blue-100 text-blue-600 rounded-lg">Karyawan</a></li>
        <li><a href="/absensi" class="p-2 block">Absensi</a></li>
    </ul>
</aside>

<!-- CONTENT -->
<main class="flex-1 p-6">

<h2 class="text-2xl font-bold mb-4">Data Karyawan</h2>

<!-- FILTER -->
<div class="flex gap-3 mb-4">

    <form method="GET" action="/karyawan" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari NIP..."
            class="border p-2 rounded-lg">

        <button class="bg-blue-500 text-white px-3 rounded-lg">Search</button>
    </form>

    <form method="GET" action="/karyawan" class="flex gap-2">
        <select name="divisi" class="border p-2 rounded-lg">
            <option value="">Semua</option>
            <option value="IT">IT</option>
            <option value="HRD">HRD</option>
            <option value="Finance">Finance</option>
        </select>

        <button class="bg-green-500 text-white px-3 rounded-lg">Filter</button>
    </form>

</div>

<!-- TABLE -->
<div class="bg-white p-6 rounded-2xl shadow">

<table class="w-full text-sm">
<thead class="bg-gray-100 text-left">
<tr>
    <th class="p-3">NIP</th>
    <th class="p-3">Nama</th>
    <th class="p-3">Email</th>
    <th class="p-3">Jabatan</th>
    <th class="p-3">Divisi</th>
    <th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>
@foreach($karyawan as $k)
<tr class="border-b">
    <td class="p-3">{{ $k->nip }}</td>
    <td class="p-3">{{ $k->nama }}</td>
    <td class="p-3">{{ $k->email }}</td>
    <td class="p-3">{{ $k->jabatan }}</td>
    <td class="p-3">{{ $k->divisi }}</td>

    <td class="p-3">
        <form action="/karyawan/{{ $k->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button class="bg-red-500 text-white px-3 py-1 rounded-lg">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach
</tbody>

</table>

</div>

</main>
</div>

</body>
</html>