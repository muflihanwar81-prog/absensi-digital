<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Perizinan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white flex font-sans h-screen overflow-hidden">

<!-- SIDEBAR -->
<aside class="w-64 h-screen bg-blue-500 border-r border-gray-300 flex flex-col justify-between">
    <div>
        <!-- Logo Area -->
        <div class="p-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                <span class="font-bold text-xl tracking-tight">ADMIN</span>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <nav class="mt-2">
            <ul class="text-sm font-semibold">
                <li><a href="#" class="block px-8 py-3 hover:bg-gray-100">Dashboard</a></li>
                <li class="bg-gray-300 border-l-4 border-gray-600">
                    <a href="{{ route('admin.karyawan.index') }}" class="block px-8 py-3 hover:bg-gray-100">Data Karyawan</a>
                </li>
                <li><a href="#" class="block px-8 py-3 hover:bg-gray-100">Kelola Divisi</a></li>
                <li><a href="{{ route('admin.absensi.index') }}" class="block px-8 py-3 hover:bg-gray-100">Data Absensi</a></li>
                <li><a href="{{ route('admin.perizinan.index') }}" class="block px-8 py-3 hover:bg-gray-100">Data Perizinan</a></li>
                <li><a href="#" class="block px-8 py-3 hover:bg-gray-100">Laporan</a></li>
            </ul>
        </nav>
    </div>

    <!-- User Profile / Footer Sidebar -->
    <div class="p-4">
        <div class="bg-gray-300 py-3 px-6 font-bold text-lg rounded-sm inline-block w-full">
            DK
        </div>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 flex flex-col bg-gray-50">
    
    <!-- HEADER -->
    <header class="bg-blue-500 p-6 border-b border-gray-400">
        <h1 class="text-3xl font-bold text-gray-800">Data Perizinan Karyawan</h1>
    </header>

    <div class="p-8">
        <!-- SEARCH BAR -->
        <div class="mb-6">
            <input type="text" placeholder="Pencarian.." 
                class="bg-gray-300 border-none rounded-lg px-4 py-2 w-72 focus:ring-2 focus:ring-gray-400 placeholder-gray-600">
        </div>

        <!-- TABLE CONTAINER -->
        <div class="bg-white border border-gray-400 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-300 border-b border-gray-400">
                    <tr>
                        <th class="px-4 py-3 w-10 text-center border-r border-gray-400">
                            <input type="checkbox" class="rounded border-gray-400">
                        </th>
                        <th class="px-4 py-3 border-r border-gray-400 font-bold">NIP</th>
                        <th class="px-4 py-3 border-r border-gray-400 font-bold">Nama</th>
                        <th class="px-4 py-3 border-r border-gray-400 font-bold">Jenis Izin</th>
                        <th class="px-4 py-3 border-r border-gray-400 font-bold">Tanggal</th>
                        <th class="px-4 py-3 border-r border-gray-400 font-bold text-center">Status</th>
                        <th class="px-4 py-3 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perizinan as $p)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-center border-r border-gray-200">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-4 py-3 border-r border-gray-200 font-mono text-sm">{{ $p->nip }}</td>
                        <td class="px-4 py-3 border-r border-gray-200">{{ $p->nama }}</td>
                        <td class="px-4 py-3 border-r border-gray-200">{{ $p->jenis }}</td>
                        <td class="px-4 py-3 border-r border-gray-200">{{ $p->tanggal }}</td>
                        <td class="px-4 py-3 border-r border-gray-200 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $p->status == 'Disetujui' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:underline font-bold text-sm">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-20 text-center text-gray-400 italic">Belum ada data perizinan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>