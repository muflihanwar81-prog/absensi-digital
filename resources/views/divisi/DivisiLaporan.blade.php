<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - CODIA-SYNC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-blue-50 antialiased font-sans">

    <div class="flex">
        {{-- SIDEBAR --}}
        @include('layouts.partials.sidebar-divisi')

        <div class="flex-1 flex flex-col min-h-screen">

            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 shadow-lg">
                <h2 class="text-3xl font-bold text-white">Laporan Kehadiran</h2>
            </div>

            <div class="p-8">

                <div class="mb-6 flex flex-wrap gap-4 items-center bg-white p-4 rounded-xl border border-blue-200 shadow-sm">
                    
                    {{-- SEARCH PENCARIAN --}}
                    <div class="w-full md:w-auto flex-1 min-w-[250px]">
                        <input type="text"
                               placeholder="Pencarian.."
                               class="w-full p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-400 font-semibold text-sm text-blue-900">
                    </div>

                    {{-- FILTER TANGGAL MULAI --}}
                    <div class="w-full md:w-auto">
                        <input type="date"
                               class="w-full p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none font-semibold text-sm text-blue-900">
                    </div>

                    {{-- PEMBATAS TANGGAL --}}
                    <span class="text-xs font-bold text-blue-400 uppercase tracking-wider px-1 mx-auto md:mx-0">
                        S/D
                    </span>

                    {{-- FILTER TANGGAL SELESAI --}}
                    <div class="w-full md:w-auto">
                        <input type="date"
                               class="w-full p-3 bg-white rounded-xl border border-blue-200 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none font-semibold text-sm text-blue-900">
                    </div>

                    {{-- BUTTON FILTER --}}
                    <button class="w-full md:w-auto px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md transition">
                        Filter
                    </button>

                    {{-- EXPORT UTILITIES (Excel & PDF) --}}
                    <div class="w-full md:w-auto flex gap-2 md:ml-auto">
                        <a href="{{ route('admin.laporan.excel') }}"
                           class="flex-1 md:flex-initial text-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl font-bold text-sm shadow-sm transition">
                           <i class="fa-solid fa-file-excel mr-1"></i> Excel
                        </a>
                        <a href="{{ route('admin.laporan.pdf') }}"
                           class="flex-1 md:flex-initial text-center bg-rose-600 hover:bg-rose-700 text-white px-4 py-3 rounded-xl font-bold text-sm shadow-sm transition">
                           <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                        </a>
                    </div>

                </div>

                <div class="bg-white border border-blue-200 rounded-xl overflow-hidden shadow-sm">

                    <table class="w-full text-left border-collapse">

                        <thead>
                            <tr class="bg-blue-100 border-b border-blue-200 text-sm font-bold text-blue-900">
                                <th class="py-3 px-4 border-r border-blue-200 w-12 text-center">No</th>
                                <th class="py-3 px-4 border-r border-blue-200">NIP</th>
                                <th class="py-3 px-4 border-r border-blue-200">Nama</th>
                                <th class="py-3 px-4 border-r border-blue-200">Divisi</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jabatan</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jam Masuk</th>
                                <th class="py-3 px-4 border-r border-blue-200">Jam Keluar</th>
                                <th class="py-3 px-4 text-center">Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($absensi as $item)
                            <tr class="border-b border-blue-100 hover:bg-blue-50/50 transition">
                                <td class="py-3 px-4 border-r border-blue-200 text-center text-blue-900 font-semibold text-sm">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-950 font-bold text-sm">
                                    {{ optional($item->karyawan)->nip ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-900 text-sm font-medium">
                                    {{ optional($item->karyawan)->nama ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-900 text-sm">
                                    {{ optional($item->karyawan)->divisi ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-blue-900 text-sm">
                                    {{ optional($item->karyawan)->jabatan ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-sm">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-r border-blue-200 text-sm">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 font-mono">
                                        {{ $item->jam_keluar ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center text-blue-950 font-mono text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr class="h-64">
                                <td colspan="8" class="text-center text-blue-300 italic font-medium">
                                    Belum ada data laporan absensi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>