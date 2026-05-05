<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi - ADMIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white flex font-sans">

<!-- SIDEBAR -->
<aside class="w-64 h-screen bg-blue-500 border-r border-gray-300 flex flex-col justify-between">
    <div>
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
            <span class="font-bold text-xl tracking-tight">ADMIN</span>
        </div>

        <nav class="mt-2">
            <ul class="text-sm font-semibold">
                <li><a href="#" class="block px-8 py-3 hover:bg-gray-100">Dashboard</a></li>
                <li><a href="{{ route('admin.karyawan.index') }}" class="block px-8 py-3 hover:bg-gray-100">Data Karyawan</a></li>
                <li><a href="#" class="block px-8 py-3 hover:bg-gray-100">Kelola Divisi</a></li>
                <li class="bg-gray-300 border-l-4 border-gray-600">
                    <a href="{{ route('admin.absensi.index') }}" class="block px-8 py-3 hover:bg-gray-100">Data Absensi</a>
                </li>
                <li><a href="{{ route('admin.perizinan.index') }}" class="block px-8 py-3 hover:bg-gray-100">Data Perizinan</a></li>
                <li><a href="#" class="block px-8 py-3 hover:bg-gray-100">Laporan</a></li>
            </ul>
        </nav>
    </div>
    <div class="p-4">
        <div class="bg-gray-300 py-3 px-6 font-bold text-lg rounded-sm inline-block w-full">DK</div>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 overflow-y-auto">
    <!-- Header bar -->

    <div class="bg-blue-500 p-6 rounded-sm mb-8 border-b border-gray-400">
        <h1 class="text-3xl font-bold text-gray-800">Data Absensi</h1>
    </div>

        <!-- Filter Bar -->
        <div class="flex gap-4 mb-6">
            <form action="{{ route('admin.absensi.index') }}" method="GET" class="flex gap-4 w-1/2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pencarian.." 
                    class="bg-gray-200 border-none rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-gray-300">
                <button type="submit" class="bg-gray-300 font-bold px-10 py-2 rounded-lg hover:bg-gray-400 transition">
                    Filter
                </button>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white border border-gray-400 rounded-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-300 border-b border-gray-400 text-sm font-bold">
                    <tr>
                        <th class="px-4 py-3 border-r border-gray-400 text-center w-12">No</th>
                        <th class="px-4 py-3 border-r border-gray-400">Nip</th>
                        <th class="px-4 py-3 border-r border-gray-400">Nama</th>
                        <th class="px-4 py-3 border-r border-gray-400">Divisi</th>
                        <th class="px-4 py-3 border-r border-gray-400">Jabatan</th>
                        <th class="px-4 py-3 border-r border-gray-400">Jam Masuk</th>
                        <th class="px-4 py-3 border-r border-gray-400">Jam Keluar</th>
                        <th class="px-4 py-3 border-r border-gray-400">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $index => $a)
                    <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 border-r border-gray-400 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 border-r border-gray-400 font-mono text-sm">{{ $a->nip }}</td>
                        <td class="px-4 py-3 border-r border-gray-400">{{ $a->nama }}</td>
                        <td class="px-4 py-3 border-r border-gray-400">{{ $a->divisi }}</td>
                        <td class="px-4 py-3 border-r border-gray-400">{{ $a->jabatan }}</td>
                        <td class="px-4 py-3 border-r border-gray-400 text-green-600 font-semibold">{{ $a->jam_masuk }}</td>
                        <td class="px-4 py-3 border-r border-gray-400 text-red-600 font-semibold">{{ $a->jam_keluar }}</td>
                        <td class="px-4 py-3 border-r border-gray-400 italic text-gray-600">{{ $a->tanggal }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-blue-600 font-bold hover:underline text-sm">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="h-64">
                        <td colspan="9" class="text-center text-gray-400 italic">Data absensi tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>