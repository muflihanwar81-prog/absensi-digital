<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white flex font-sans">

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
<main class="flex-1 overflow-y-auto">

    <div class="bg-blue-500 p-6 rounded-sm mb-8 border-b border-gray-400">
        <h1 class="text-3xl font-bold text-gray-800">Data Karyawan</h1>
    </div>
        <!-- CARD STATS (Grey Background Container) -->
        <div class="bg-gray-300 p-10 rounded-lg grid grid-cols-4 gap-4 mb-10 shadow-sm">
            <div class="text-center">
                <p class="text-xs font-bold mb-4">Divisi A</p>
                <h2 class="text-6xl font-black">{{ $stats['divisi_a'] }}</h2>
            </div>
            <div class="text-center">
                <p class="text-xs font-bold mb-4">Divisi B</p>
                <h2 class="text-6xl font-black">{{ $stats['divisi_a'] }}</h2>
            </div>
            <div class="text-center">
                <p class="text-xs font-bold mb-4">Divisi C</p>
                <h2 class="text-6xl font-black">{{ $stats['divisi_a'] }}</h2>
            </div>
            <div class="text-center">
                <p class="text-xs font-bold mb-4">Divisi D</p>
                <h2 class="text-6xl font-black">{{ $stats['divisi_a'] }}</h2>
            </div>
        </div>

        <!-- ACTION BAR (Search, Filter, Add) -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-4 w-2/3">
                <input type="text" placeholder="Pencarian.." 
                    class="bg-gray-200 border-none rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-gray-400">
                <button class="bg-gray-300 font-bold px-10 py-3 rounded-lg hover:bg-gray-400 transition">
                    Filter
                </button>
            </div>
            <button class="bg-gray-300 font-bold px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-gray-400 transition">
                <span class="text-xl">+</span> Tambah data
            </button>
        </div>

        <!-- DATA TABLE -->
        <div class="bg-white border border-gray-400 rounded-sm overflow-hidden mt-6">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200 border-b border-gray-400 text-sm font-bold">
                    <tr>
                        <th class="px-4 py-3 border-r border-gray-400 text-center w-12">No</th>
                        <th class="px-4 py-3 border-r border-gray-400">Nip</th>
                        <th class="px-4 py-3 border-r border-gray-400">Nama</th>
                        <th class="px-4 py-3 border-r border-gray-400">Divisi</th>
                        <th class="px-4 py-3 border-r border-gray-400">Jabatan</th>
                        <th class="px-4 py-3 border-r border-gray-400">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $index => $k)
                        <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 border-r border-gray-400 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 border-r border-gray-400 font-mono text-sm">{{ $k->nip }}</td>
                            <td class="px-4 py-3 border-r border-gray-400">{{ $k->nama }}</td>
                            <td class="px-4 py-3 border-r border-gray-400">{{ $k->divisi }}</td>
                            <td class="px-4 py-3 border-r border-gray-400">{{ $k->jabatan }}</td>
                            <td class="px-4 py-3 border-r border-gray-400 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $k->status == 'Aktif' ? 'bg-green-200 text-green-700' : 'bg-orange-200 text-orange-700' }}">
                                    {{ $k->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="#" class="text-blue-600 font-bold hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="h-64">
                            <td colspan="7" class="text-center text-gray-400 italic">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

</body>
</html>