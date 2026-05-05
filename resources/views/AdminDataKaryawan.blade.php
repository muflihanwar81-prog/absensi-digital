<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white flex font-sans overflow-hidden">

    <!-- SIDEBAR -->
    @include('layouts.partials.sidebar')

    <!-- MAIN CONTENT -->
    <main class="flex-1 h-screen overflow-y-auto">

        <!-- HEADER -->
    @include('layouts.partials.header', ['title' => 'Data Karyawan'])

        <div class="p-8">
            <!-- CARD STATS -->
            <div class="bg-gray-300 p-10 rounded-lg grid grid-cols-4 gap-4 mb-10 shadow-sm text-gray-800">
                <div class="text-center">
                    <p class="text-xs font-bold mb-4 uppercase">Divisi A</p>
                    <h2 class="text-6xl font-black">{{ $stats['divisi_a'] }}</h2>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold mb-4 uppercase">Divisi B</p>
                    <h2 class="text-6xl font-black">{{ $stats['divisi_b'] }}</h2>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold mb-4 uppercase">Divisi C</p>
                    <h2 class="text-6xl font-black">{{ $stats['divisi_c'] }}</h2>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold mb-4 uppercase">Divisi D</p>
                    <h2 class="text-6xl font-black">{{ $stats['divisi_d'] }}</h2>
                </div>
            </div>

            <!-- ACTION BAR (Search, Filter, Add) -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex gap-4 w-2/3">
                    <form action="{{ route('admin.karyawan.index') }}" method="GET" class="flex gap-4 w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Pencarian.." 
                            class="bg-gray-200 border-none rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-gray-400">
                        <button type="submit" class="bg-gray-300 font-bold px-10 py-3 rounded-lg hover:bg-gray-400 transition">
                            Filter
                        </button>
                    </form>
                </div>
                <a href="#" class="bg-gray-300 font-bold px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-gray-400 transition">
                    <span class="text-xl">+</span> Tambah data
                </a>
            </div>

            <!-- DATA TABLE -->
            <div class="bg-white border border-gray-400 rounded-sm overflow-hidden">
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
                            <tr class="border-b border-gray-300 hover:bg-gray-50 transition text-gray-700">
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