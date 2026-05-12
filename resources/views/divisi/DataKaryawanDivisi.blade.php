<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - CODIA-SYNC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Data Karyawan</h2>
            </div>

            <!-- Content -->
            <div class="p-8">

                <!-- Search Box -->
                <div class="mb-6">
                    <input type="text"
                           placeholder="Pencarian.."
                           class="w-full md:w-1/3 p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400 font-semibold text-sm text-blue-900">
                </div>

                <!-- Table Container -->
                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">

                    <table class="w-full text-left border-collapse">

                        <!-- Table Header -->
                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-sm font-bold text-blue-900">
                                <th class="py-3 px-4 border-r border-blue-200 w-12 text-center">No</th>
                                <th class="py-3 px-4 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-4 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-4 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-4 border-r border-blue-200">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                            <tr class="h-96">
                                <td colspan="7"
                                    class="text-center text-blue-300 italic font-medium">
                                    Belum ada data karyawan
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