<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased font-sans">

    <div class="flex">
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <div class="bg-blue-500 p-6 shadow-inner">
                <h2 class="text-3xl font-bold text-gray-800">Data Karyawan</h2>
            </div>

            <div class="p-8">
                <div class="mb-6">
                    <input type="text" 
                           placeholder="Pencarian.." 
                           class="w-full md:w-1/3 p-2 bg-gray-300 rounded-lg border-none focus:ring-2 focus:ring-gray-400 placeholder-gray-600 font-semibold text-sm">
                </div>

                <div class="bg-white border border-gray-400 rounded-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-300 border-b border-gray-400 text-sm font-bold text-gray-800">
                                <th class="py-3 px-4 border-r border-gray-400 w-12 text-center">No</th>
                                <th class="py-3 px-4 border-r border-gray-400">Nip</th>
                                <th class="py-3 px-4 border-r border-gray-400">Nama</th>
                                <th class="py-3 px-4 border-r border-gray-400">Divisi</th>
                                <th class="py-3 px-4 border-r border-gray-400">Jabatan</th>
                                <th class="py-3 px-4 border-r border-gray-400">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="h-96">
                                <td colspan="7" class="text-center text-gray-400 italic">
                                    Belum ada data karyawan...
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