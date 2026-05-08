<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased font-sans">

    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Judul Halaman -->
            <div class="bg-blue-500 p-6 shadow-inner">
                <h2 class="text-3xl font-bold text-gray-800">Laporan</h2>
            </div>

            <!-- Konten -->
            <div class="p-8">
                <!-- Toolbar Laporan -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <!-- Left Section: Search & Date -->
                    <div class="flex items-center gap-3">
                        <input type="text" placeholder="Pencarian.." 
                               class="p-2 bg-gray-300 rounded-lg border-none focus:ring-2 focus:ring-gray-400 placeholder-gray-600 font-semibold text-sm w-64">
                        
                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Rentang Tanggal" class="p-2 bg-gray-300 rounded-lg border-none text-[11px] font-semibold w-32 text-center">
                            <span class="font-bold text-gray-700 text-xs">S/D</span>
                            <input type="text" placeholder="Rentang Tanggal" class="p-2 bg-gray-300 rounded-lg border-none text-[11px] font-semibold w-32 text-center">
                        </div>

                        <button class="px-6 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg font-bold text-sm text-gray-800 transition">
                            Filter
                        </button>
                    </div>

                    <!-- Right Section: Export Buttons -->
                    <div class="flex items-center gap-3">
                        <button class="px-8 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg font-bold text-sm text-gray-800 transition uppercase">
                            Excel
                        </button>
                        <button class="px-8 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg font-bold text-sm text-gray-800 transition uppercase">
                            PDF
                        </button>
                    </div>
                </div>

                <!-- Tabel Laporan -->
                <div class="bg-white border border-gray-400 rounded-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-300 border-b border-gray-400 text-[11px] font-bold text-gray-800 uppercase tracking-tight">
                                <th class="py-3 px-2 border-r border-gray-400 w-12 text-center">No</th>
                                <th class="py-3 px-3 border-r border-gray-400">Nip</th>
                                <th class="py-3 px-3 border-r border-gray-400">Nama</th>
                                <th class="py-3 px-3 border-r border-gray-400">Divisi</th>
                                <th class="py-3 px-3 border-r border-gray-400">Jabatan</th>
                                <th class="py-3 px-3 border-r border-gray-400">Jam Masuk</th>
                                <th class="py-3 px-3 border-r border-gray-400">Jam Keluar</th>
                                <th class="py-3 px-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="h-96">
                                <td colspan="8" class="text-center text-gray-400 italic text-sm">
                                    Data laporan belum tersedia...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>