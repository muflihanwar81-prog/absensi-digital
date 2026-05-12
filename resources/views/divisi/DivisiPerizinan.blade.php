<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Perizinan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <!-- Judul Halaman -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Data Perizinan</h2>
            </div>

            <!-- Konten -->
            <div class="p-8">

                <!-- Filter -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <div class="flex-1 min-w-[300px]">
                        <input type="text"
                               placeholder="Pencarian.."
                               class="w-full p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400 font-semibold text-sm text-blue-900">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="text"
                               placeholder="Rentang Tanggal"
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-[12px] font-semibold w-36 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        <span class="font-bold text-blue-700 text-sm">S/D</span>

                        <input type="text"
                               placeholder="Rentang Tanggal"
                               class="p-3 bg-white rounded-xl border border-blue-200 shadow-sm text-[12px] font-semibold w-36 text-center text-blue-900 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>
                </div>

                <!-- Tabel Perizinan -->
                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-[11px] font-bold text-blue-900 uppercase">
                                <th class="py-3 px-2 border-r border-blue-200 w-10 text-center">No</th>
                                <th class="py-3 px-3 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-3 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-3 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-3 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-3 border-r border-blue-200">Kategori</th>
                                <th class="py-3 px-3 border-r border-blue-200">Bukti</th>
                                <th class="py-3 px-3 border-r border-blue-200">Tanggal</th>
                                <th class="py-3 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="h-96">
                                <td colspan="9"
                                    class="text-center text-blue-300 italic text-sm font-medium">
                                    Tidak ada data perizinan...
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