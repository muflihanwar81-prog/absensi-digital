<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absen - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased font-sans">

    <div class="flex">
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <div class="bg-blue-500 p-6 shadow-inner">
                <h2 class="text-3xl font-bold text-gray-800">Riwayat Abseni</h2>
            </div>

            <div class="p-8">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <div class="flex-1 min-w-[300px]">
                        <input type="text" placeholder="Pencarian.." 
                               class="w-full p-2 bg-gray-300 rounded-lg border-none focus:ring-2 focus:ring-gray-400 placeholder-gray-600 font-semibold text-sm">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="text" placeholder="Rentang Tanggal" class="p-2 bg-gray-300 rounded-lg border-none text-sm font-semibold w-40 text-center">
                        <span class="font-bold text-gray-700">S/D</span>
                        <input type="text" placeholder="Rentang Tanggal" class="p-2 bg-gray-300 rounded-lg border-none text-sm font-semibold w-40 text-center">
                    </div>
                </div>

                <div class="bg-white border border-gray-400 rounded-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-300 border-b border-gray-400 text-[11px] font-bold text-gray-800 uppercase tracking-tighter">
                                <th class="py-3 px-2 border-r border-gray-400 w-10 text-center">No</th>
                                <th class="py-3 px-3 border-r border-gray-400">Nip</th>
                                <th class="py-3 px-3 border-r border-gray-400">Nama</th>
                                <th class="py-3 px-3 border-r border-gray-400">Divisi</th>
                                <th class="py-3 px-3 border-r border-gray-400">Jabatan</th>
                                <th class="py-3 px-3 border-r border-gray-400">Jam Masuk</th>
                                <th class="py-3 px-3 border-r border-gray-400">Jam Keluar</th>
                                <th class="py-3 px-3 border-r border-gray-400">Tanggal</th>
                                <th class="py-3 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="h-96">
                                <td colspan="9" class="text-center text-gray-400 italic text-sm">
                                    Tidak ada data riwayat absensi untuk ditampilkan...
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