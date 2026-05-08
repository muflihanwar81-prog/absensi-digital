<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Perizinan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white flex font-sans h-screen overflow-hidden">

    <!-- Memanggil Sidebar (Otomatis menangani menu aktif) -->
    @include('layouts.partials.sidebar')

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col bg-gray-50 overflow-y-auto">
        
        <!-- Memanggil Header dengan judul dinamis -->
        @include('layouts.partials.header', ['title' => 'Data Perizinan Karyawan'])

        <div class="p-8">
            <!-- SEARCH BAR -->
            <div class="mb-6">
                <form action="{{ route('admin.perizinan.index') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Pencarian.." 
                        class="bg-gray-300 border-none rounded-lg px-4 py-2 w-72 focus:ring-2 focus:ring-gray-400 placeholder-gray-600 text-gray-800">
                </form>
            </div>

            <!-- TABLE CONTAINER -->
            <div class="bg-white border border-gray-400 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-300 border-b border-gray-400">
                        <tr class="text-gray-800">
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
                        <tr class="border-b border-gray-200 hover:bg-gray-50 text-gray-700">
                            <td class="px-4 py-3 text-center border-r border-gray-200">
                                <input type="checkbox" class="rounded border-gray-300">
                            </td>
                            <td class="px-4 py-3 border-r border-gray-200 font-mono text-sm uppercase">{{ $p->nip }}</td>
                            <td class="px-4 py-3 border-r border-gray-200 uppercase font-semibold">{{ $p->nama }}</td>
                            <td class="px-4 py-3 border-r border-gray-200">{{ $p->jenis }}</td>
                            <td class="px-4 py-3 border-r border-gray-200">{{ $p->tanggal }}</td>
                            <td class="px-4 py-3 border-r border-gray-200 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $p->status == 'Disetujui' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="#" class="text-blue-600 hover:underline font-bold text-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-20 text-center text-gray-400 italic">
                                Belum ada data perizinan masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>